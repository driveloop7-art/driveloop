<x-app-layout>
    <section class="docs-card">
        <h3 class="docs-title">Documentos del vehículo</h3>

        <form class="docs-form" action="{{ route('vehiculo.documentos.store') }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            <div class="docs-grid">
                <div class="docs-left">

                    <input type="hidden" name="codveh" value="{{ $vehiculo->cod }}">
                    {{-- Placa --}}
                    <div class="docs-row">
                        <label class="docs-label" for="placa">Placa del vehículo</label>
                        <input id="placa" class="docs-input is-wide" type="text" name="placa"
                            placeholder="Ej: ABC123" required maxlength="10" style="text-transform: uppercase;">
                        <small class="help">Escribe la placa tal como aparece en la tarjeta de propiedad.</small>
                    </div>

                    {{-- Tarjeta de propiedad --}}
                    <div class="docs-row">
                        <label class="docs-label" for="doc_tarjeta">Tarjeta de propiedad</label>

                        <div class="docs-actions">
                            <label class="btn-file">
                                Seleccionar archivo
                                <input id="doc_tarjeta" type="file" name="documentos[0][archivo]"
                                    accept=".pdf,.jpg,.jpeg,.png" required>
                            </label>

                            <span class="docs-status" id="status_tarjeta">Ningún archivo seleccionado</span>
                        </div>

                        <input type="hidden" name="documentos[0][idtipdoc]" value="1">
                        <small class="help">Formatos permitidos: PDF, JPG, JPEG, PNG (máx. 10MB).</small>
                    </div>

                    {{-- SOAT --}}
                    <div class="docs-row">
                        <label class="docs-label" for="doc_soat">SOAT vigente</label>

                        <div class="docs-actions">
                            <label class="btn-file">
                                Seleccionar archivo
                                <input id="doc_soat" type="file" name="documentos[1][archivo]"
                                    accept=".pdf,.jpg,.jpeg,.png" required>
                            </label>

                            <span class="docs-status" id="status_soat">Ningún archivo seleccionado</span>
                        </div>

                        <input type="hidden" name="documentos[1][idtipdoc]" value="2">
                        <small class="help">Sube el SOAT vigente. Puede ser PDF o imagen.</small>
                    </div>

                    {{-- TECNOMECÁNICA --}}
                    <div class="docs-row">
                        <label class="docs-label" for="doc_tecno">Certificado tecnomecánico</label>

                        <div class="docs-actions">
                            <label class="btn-file">
                                Seleccionar archivo
                                <input id="doc_tecno" type="file" name="documentos[2][archivo]"
                                    accept=".pdf,.jpg,.jpeg,.png" required>
                            </label>

                            <span class="docs-status" id="status_tecno">Ningún archivo seleccionado</span>
                        </div>

                        {{-- OJO: este id debe ser el real en tu tabla tipo_documento --}}
                        <input type="hidden" name="documentos[2][idtipdoc]" value="3">
                        <small class="help">Sube la tecnomecánica vigente. PDF o imagen (máx. 10MB).</small>
                    </div>

                </div>
                {{-- Fotos --}}
                <div class="grid-fotos">
                    <div class="docs-row">
                        <label class="docs-label" for="fotos">Fotos del vehículo</label>

                        <label class="photo-drop" for="fotos">
                            <input id="fotos" type="file" name="fotos[]" accept="image/*" multiple>

                            <div class="photo-inner">
                                <div class="photo-text">Añadir fotos</div>
                                <div class="docs-status">Haz clic aquí para seleccionar hasta 10 imágenes</div>
                            </div>
                        </label>

                        <small class="help" id="photoHelp">0/10 fotos seleccionadas</small>
                        <small class="error" id="photoError" style="display:none;"></small>
                    </div>

                    <div class="docs-right">
                        {{-- Panel preview --}}
                        <div class="photo-preview" id="photoPreview">
                            <p class="photo-empty" id="photoEmpty">Aquí se mostrarán las fotos seleccionadas (máximo
                                10).
                            </p>
                        </div>

                        <button id="btnContinuar" type="submit" class="btn-submit">Continuar</button>
                    </div>
                </div>
            </div>
        </form>
    </section>

    <script>
        (function() {
            const MAX = 10;

            const fotosInput = document.getElementById('fotos');
            const previewWrap = document.getElementById('photoPreview');
            const emptyText = document.getElementById('photoEmpty');
            const help = document.getElementById('photoHelp');
            const errorBox = document.getElementById('photoError');
            const btn = document.getElementById('btnContinuar');

            const placaInput = document.getElementById('placa');
            const doc0 = document.getElementById('doc_tarjeta');
            const doc1 = document.getElementById('doc_soat');
            const doc2 = document.getElementById('doc_tecno');

            const st0 = document.getElementById('status_tarjeta');
            const st1 = document.getElementById('status_soat');
            const st2 = document.getElementById('status_tecno');

            let selectedFiles = [];

            function showError(msg) {
                errorBox.textContent = msg;
                errorBox.style.display = msg ? 'block' : 'none';
            }

            function updateFileStatus(input, statusEl) {
                if (!input || !statusEl) return;
                statusEl.textContent = input.files?.length ? input.files[0].name : 'Ningún archivo seleccionado';
                statusEl.classList.toggle('is-ok', !!input.files?.length);
            }

            function updateButtonState() {
                const placaOk = placaInput && placaInput.value.trim().length > 0;
                const docsOk = doc0 && doc0.files.length === 1 &&
                    doc1 && doc1.files.length === 1 &&
                    doc2 && doc2.files.length === 1;
                btn.disabled = !(placaOk && docsOk);
            }

            function syncInputFiles() {
                const dt = new DataTransfer();
                selectedFiles.forEach(f => dt.items.add(f));
                fotosInput.files = dt.files;
            }

            function render() {
                previewWrap.querySelector('.photo-grid')?.remove();

                if (selectedFiles.length === 0) {
                    emptyText.style.display = 'block';
                    help.textContent = `0/${MAX} fotos seleccionadas`;
                    updateButtonState();
                    return;
                }

                emptyText.style.display = 'none';
                help.textContent = `${selectedFiles.length}/${MAX} fotos seleccionadas`;

                const grid = document.createElement('div');
                grid.className = 'photo-grid';

                selectedFiles.forEach((file, idx) => {
                    const card = document.createElement('div');
                    card.className = 'photo-card';

                    const img = document.createElement('img');
                    img.alt = file.name;

                    const url = URL.createObjectURL(file);
                    img.src = url;
                    img.onload = () => URL.revokeObjectURL(url);

                    const meta = document.createElement('div');
                    meta.className = 'meta';
                    meta.textContent = file.name;

                    const removeBtn = document.createElement('button');
                    removeBtn.type = 'button';
                    removeBtn.textContent = 'Quitar';
                    removeBtn.addEventListener('click', () => {
                        selectedFiles.splice(idx, 1);
                        syncInputFiles();
                        render();
                    });

                    card.appendChild(img);
                    card.appendChild(meta);
                    card.appendChild(removeBtn);
                    grid.appendChild(card);
                });

                previewWrap.appendChild(grid);
                updateButtonState();
            }

            fotosInput.addEventListener('change', () => {
                showError('');

                const incoming = Array.from(fotosInput.files || []);
                const combined = [...selectedFiles, ...incoming];

                selectedFiles = combined.slice(0, MAX).filter(f => f.type.startsWith('image/'));

                if (combined.length > MAX) {
                    showError(`Máximo ${MAX} fotos. Estás intentando seleccionar ${combined.length}.`);
                }

                syncInputFiles();
                render();
            });

            placaInput?.addEventListener('input', updateButtonState);

            doc0?.addEventListener('change', () => {
                updateFileStatus(doc0, st0);
                updateButtonState();
            });

            doc1?.addEventListener('change', () => {
                updateFileStatus(doc1, st1);
                updateButtonState();
            });

            doc2?.addEventListener('change', () => {
                updateFileStatus(doc2, st2);
                updateButtonState();
            });


            updateFileStatus(doc0, st0);
            updateFileStatus(doc1, st1);
            updateFileStatus(doc2, st2);
            updateButtonState();
            render();
        })();
    </script>
</x-app-layout>
