import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.data('passwordMeter', () => ({
    password: '',
    conditions: {
        length: false,
        uppercase: false,
        number: false,
        special: false
    },
    strength: 'none',
    
    checkPassword() {
        this.conditions.length = this.password.length >= 8;
        this.conditions.uppercase = /[A-Z]/.test(this.password);
        this.conditions.number = /[0-9]/.test(this.password);
        this.conditions.special = /[!@#\$%\^&\*\(\),\.?":\{\}\|<>\-_\+=\/\\\[\]~;']/.test(this.password);
        
        let metCount = Object.values(this.conditions).filter(Boolean).length;
        
        if (this.password.length === 0) {
            this.strength = 'none';
        } else if (metCount <= 2) {
            this.strength = 'low';
        } else if (metCount === 3) {
            this.strength = 'medium';
        } else if (metCount === 4) {
            this.strength = 'high';
        }
    },
    
    get allConditionsMet() {
        return this.conditions.length && this.conditions.uppercase && this.conditions.number && this.conditions.special;
    },
    
    submitForm(e) {
        if (!this.allConditionsMet) {
            e.preventDefault();
        }
    }
}));

Alpine.start();
