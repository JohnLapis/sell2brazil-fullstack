<template>
    <div class="container-fluid">
        <nav class="navbar navbar-expand navbar-dark bg-dark top" :style="{height: '100%'}">
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" href="#">Criar pedido</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="#">Listar pedidos</a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>

    <CreateOrder class="mt-3"/>
</template>

<script>
import CreateOrder from './components/tabs/CreateOrder.vue'
import ListOrders from './components/tabs/ListOrders.vue'

export default {
  name: 'App',
  components: {
    CreateOrder,
    ListOrders,
  }
}
</script>

<style>
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
}
</style>
