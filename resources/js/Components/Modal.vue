<template>
  <div class="modal" v-if="show">
    <div class="modal-content">
      <span class="close" @click="$emit('close')">&times;</span>
      <h2>Détails du produit</h2>
      <p><strong>Nom :</strong> {{ product.name }}</p>
      <p><strong>Description :</strong> {{ product.description }}</p>
      <p><strong>Prix :</strong> {{ product.price }} €</p>
      <img v-if="product.image_url" :src="product.image_url" alt="Image du produit" />
    </div>
  </div>
</template>

<script>
export default {
  props: {
    show: {
      type: Boolean,
      required: true,
    },
    product: {
      type: Object,
      required: true,
    },
  },
};
</script>

<style scoped>
.modal {
  display: block;
  position: fixed;
  z-index: 1;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  overflow: auto;
  background-color: rgba(0, 0, 0, 0.4);
}

.modal-content {
  background-color: #fff;
  margin: 15% auto;
  padding: 20px;
  border: 1px solid #888;
  width: 80%;
  max-width: 600px;
}

.close {
  color: #aaa;
  float: right;
  font-size: 28px;
  font-weight: bold;
}

.close:hover,
.close:focus {
  color: black;
  text-decoration: none;
  cursor: pointer;
}
</style>
