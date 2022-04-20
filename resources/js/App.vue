<template>
    <input v-model="ArticleCode" maxlength="50">
    <input v-model="ArticleName" maxlength="50">
    <input v-model.number="UnitPrice" @keydown="isInputFloat($event)" id="quantity">
    <input v-model.number="Quantity" @keydown="isInputInteger($event)">

    <button @click="createOrder" class="btn">Enviar</button>
</template>

<script>
export default {
  name: 'App',
  data() {
    return {
	    ArticleCode: "",
	    ArticleName: "",
	    UnitPrice:   0,
	    Quantity:    0,
    }
  },
  methods: {
    listOrders() {
    },
    createOrder() {
      fetch('/api/orders', {
        method: 'POST',
        body: JSON.stringify({


        })
      })
    },
    isInputInteger(event) {
      if (event.key.length === 1 && isNaN(event.key)) event.preventDefault()
    },
    isInputFloat(event) {
      if (event.key === '.'
          && !document.querySelector("#quantity").value.includes('.')) return
      if (event.key.length === 1 && isNaN(event.key)) event.preventDefault()
    },
  }
}
</script>

<style>
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  margin-top: 60px;
}
</style>
