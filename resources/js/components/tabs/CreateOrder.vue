<template>
    <table class="table">
        <thead>
            <tr>
                <th>Código de produto</th>
                <th>Nome de produto</th>
                <th>Preço unitário</th>
                <th>Quantidade</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="prod in products">
                <td><input v-model="prod.ArticleCode" maxlength="50" placeholder="Código de produto"></td>
                <td><input v-model="prod.ArticleName" maxlength="50" placeholder="Nome de produto"></td>
                <td><input v-model.number="prod.UnitPrice"
                           @keydown="isInputFloat($event)"
                           id="quantity"
                           placeholder="Preço unitário"> </td>
                <td><input
                      v-model.number="prod.Quantity"
                      @keydown="isInputInteger($event)"
                      placeholder="Quantidade">
                </td>
            </tr>
        </tbody>
    </table>
    <button @click="addProduct" class="btn btn-dark m-3">Adicionar produto ao pedido</button>
    <button @click="fillInputsRandomly" class="btn btn-dark m-3">Preencher dados aleatoriamente</button>
    <br/>
    <button @click="createOrder" class="btn btn-dark my-3">Enviar</button>
</template>

<script>
function getRandomString() {
  return Math.random().toString(36).replace(/[\d\.]/g, "")
}

function getRandomInteger(start, end) {
  return start + Math.floor(Math.random() * (end - start))
}

function getRandomPrice() {
  return getRandomInteger(0, 1000) + getRandomInteger(0, 99) / 100
}

export default {
  name: "App",
  data() {
    return {
	    products: [{
        ArticleCode: "",
	      ArticleName: "",
	      UnitPrice: null,
	      Quantity: null,
      }],
    }
  },
  methods: {
    fillInputsRandomly() {
      for(const prod of this.products) {
        if (prod.ArticleCode === "") prod.ArticleCode = getRandomString();
	      if (prod.ArticleName === "") prod.ArticleName = getRandomString();
	      if (prod.UnitPrice === null) prod.UnitPrice = getRandomPrice();
	      if (prod.Quantity === null) prod.Quantity = getRandomInteger(1, 13);
      }
    },
    addProduct() {
	    this.products.push({
        ArticleCode: "",
	      ArticleName: "",
	      UnitPrice: null,
	      Quantity: null,
      })
    },
    async createOrder() {
      const invalidProductId = this.validateProducts()
      if (invalidProductId) return alert(`Produto na posição ${invalidProductId} é inválido.`)

      const res = await fetch("/api/orders", {
        method: "POST",
        body: JSON.stringify(this.products)
      })
      if (res.status === 201) {
        const productId = (await res.json()).id
        alert(`Pedido ${productId} criado com sucesso!`)
      }
      else alert("Erro ao criar pedido.")
    },
    validateProducts() {
      // Verifica se o usuário se deixou de preencher algum campo.
      for (let i = 0; i < this.products.length; i++) {
        const prod = this.products[i]
        if (prod.ArticleCode === ""
	          || prod.ArticleName === ""
	          || prod.UnitPrice === null
	          || prod.Quantity === null) {
          return i + 1
        }
      }
    },
    isInputInteger(event) {
      if (event.key.length === 1 && isNaN(event.key)) event.preventDefault()
    },
    isInputFloat(event) {
      if (event.key === "."
          && !document.querySelector("#quantity").value.includes(".")) return
      if (event.key.length === 1 && isNaN(event.key)) event.preventDefault()
    },
  }
}
</script>

<style>
table input {
  width: 100%;
  height: 100%;
  border: 0px;
  text-align: center;
}
</style>
