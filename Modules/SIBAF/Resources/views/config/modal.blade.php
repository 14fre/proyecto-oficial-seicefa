<!-- Modal de Configuración -->
<div class="modal fade" id="configModal" tabindex="-1" role="dialog" aria-labelledby="configModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #1a365d; color: white;">
                <h5 class="modal-title" id="configModalLabel">
                    <i class="fas fa-cog"></i> Configuración del Sistema
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center py-4">
                <div class="mb-4">
                    <i class="fas fa-book fa-4x" style="color: #1a365d; margin-bottom: 20px;"></i>
                    <h4 class="text-dark mb-3">Manual de Usuario</h4>
                    <p class="text-muted mb-4">
                        Descarga la guía completa del sistema SIBAF para todos los usuarios
                    </p>
                </div>
                
                <a href="{{ route('sibaf.manual.download', 'general') }}" 
                   class="btn btn-lg" 
                   style="background-color: #1a365d; color: white; border: none; padding: 12px 30px; border-radius: 8px; font-weight: 600; transition: all 0.3s ease;">
                    <i class="fas fa-download mr-2"></i> Descargar Manual
                </a>
            </div>
            <div class="modal-footer" style="background-color: #f8f9fa; border-top: 1px solid #dee2e6;">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fas fa-times"></i> Cerrar
                </button>
            </div>
        </div>
    </div>
</div>
