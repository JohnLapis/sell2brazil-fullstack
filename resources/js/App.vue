<template>
    <div class="container-fluid">
        <nav class="navbar navbar-expand navbar-dark bg-dark">
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <router-link class="nav-link active" to="/create-order">Criar pedido</router-link>
                    </li>
                    <li class="nav-item">
                        <router-link class="nav-link active" to="/list-orders">Listar pedidos</router-link>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
    <div class="mt-3"><router-view></router-view></div>
</template>

<script>
export default {
  name: "App",
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
