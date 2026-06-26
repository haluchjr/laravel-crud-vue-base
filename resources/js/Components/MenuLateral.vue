<script setup>
import { computed } from 'vue';
import { usePage , Link} from '@inertiajs/vue3';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
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
    
    <div class="mb-4 text-center">
            <Link href="/">
                <ApplicationLogo style="width: 80px; height: 80px;" class="text-secondary" />
            </Link>
        </div>
    <hr>
    
    <ul class="nav nav-pills flex-column mb-auto gap-2">
      <MenuItemRecursivo 
        v-for="item in linksDoBanco" 
        :key="item.id" 
        :item="item" 
      />
    </ul>
    
<div class="mt-auto pt-3 border-top ps-2">
    <div v-if="usuarioLogado" class="bg-light border rounded-pill p-2 d-flex align-items-center justify-content-between shadow-sm" style="max-width: 240px;">
        
        <Link href="/profile" class="d-flex align-items-center text-decoration-none text-dark flex-grow-1 min-width-0 pe-2" title="Ir para o perfil do usuário">
            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center fw-semibold text-uppercase flex-shrink-0" 
                 style="width: 32px; height: 32px; font-size: 14px;">
                {{ usuarioLogado.name.charAt(0) }}
            </div>
            
            <span class="ms-2 fw-medium text-truncate small">
                {{ usuarioLogado.name }}
            </span>
        </Link>

        <div class="border-start my-1" style="height: 20px;"></div>

        <div class="ps-2 flex-shrink-0">
            <Link href="/logout" method="post" as="button" title="Sair do Sistema"
                  class="btn btn-link link-secondary p-1 d-flex align-items-center rounded-circle hover-danger">
                <i class="bi bi-power fs-5"></i>
            </Link>
        </div>

    </div>
</div>
  </div>
</template>