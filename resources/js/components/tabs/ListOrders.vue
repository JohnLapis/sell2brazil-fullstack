<template>
    <button @click="listOrders" class="btn btn-dark mx-3">Listar pedidos</button>
    <table class="table">
        <thead>
            <tr>
                <th>Id</th>
                <th>Code</th>
                <th>Data</th>
                <th>Preço sem desconto</th>
                <th>Preço com desconto</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="order in orders">
                <td>{{ order.OrderId }}</td>
                <td>{{ order.OrderCode }}</td>
                <td>{{ order.OrderDate }}</td>
                <td>{{ order.TotalAmountWithoutDiscount }}</td>
                <td>{{ order.TotalAmountWithDiscount }}</td>
            </tr>
        </tbody>
    </table>
</template>

<script>
export default {
  name: 'App',
  data() {
    return {
      orders: [],
    }
  },
  methods: {
    async listOrders() {
      const res = await fetch('/api/orders')
      if (res.status === 200) this.orders = (await res.json()).data
      else alert("Erro ao listar pedidos.")
    },
  }
}
</script>
