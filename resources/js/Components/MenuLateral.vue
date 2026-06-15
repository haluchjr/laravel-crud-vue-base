<script setup>
import { computed } from 'vue';
import { usePage , Link} from '@inertiajs/vue3';

import MenuItemRecursivo from '@/Components/MenuItemRecursivo.vue';

const page = usePage();
// Pega a lista com as relações recursivas resolvidas pelo Eloquent no HandleInertiaRequests
const linksDoBanco = computed(() => page.props.menu_sistema || []);

const inertiaPage = usePage();
const flashProps = computed(() => inertiaPage.props.flash);
const usuarioLogado = computed(() => inertiaPage.props.auth?.user || null);

</script>

<template>
  <div class="d-flex flex-column flex-shrink-0 p-3 bg-white shadow-sm h-100" style="width: 250px; min-height: 100vh;">
    
    <span class="fs-5 fw-bold text-primary mb-3 ps-2">Painel Geral</span>
    <hr class="mt-0 mb-3">
    
    <ul class="nav nav-pills flex-column mb-auto gap-2">
      <MenuItemRecursivo 
        v-for="item in linksDoBanco" 
        :key="item.id" 
        :item="item" 
      />
    </ul>
    
    <div class="mt-auto pt-3 border-top small text-muted ps-2">
        <div v-if="usuarioLogado" class="bg-white border rounded-pill px-3 py-1 d-flex align-items-center gap-3 shadow-sm">
                    <div class="d-flex align-items-center">
                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center fw-bold text-uppercase me-2" 
                             style="width: 28px; height: 28px; font-size: 12px;">
                            {{ usuarioLogado.name.charAt(0) }}
                        </div>
                        <span class="fw-bold text-dark text-truncate small" style="max-width: 140px;" title="Ir para o perfil do usuário">
                            <Link href="/profile" class="btn btn-sm btn-link link-danger p-0 d-flex align-items-center meu-tooltip text-decoration-none"> {{ usuarioLogado.name }} </Link>
                        </span>
                    </div>

                    <div class="border-start ps-1 py-0.5">
                        <Link href="/logout" method="post" as="button" title="Sair" data-tooltip="Sair do Sistema"
                              class="btn btn-sm btn-link link-danger p-0 d-flex align-items-center meu-tooltip text-decoration-none">
                            <i class="bi bi-power fs-5 "></i>
                        </Link>
                        
                    </div>
                </div>
    </div>
  </div>
</template>