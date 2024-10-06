<script>
import axios from "axios";

export default {
  data() {
    return {
      newCategory: {
        name: "",
      },
      categories: [],
    };
  },
  methods: {
    async addCategory() {
      await axios.post("/api/add_categories", this.newCategory);
      this.fetchCategories();
      this.newCategory.name = "";
    },
    async fetchCategories() {
      const response = await axios.get("/api/categories");
      this.categories = response.data;
    },
    async deleteCategory(id) {
      await axios.delete(`/api/categories/${id}`);
      this.fetchCategories();
    },
  },
  mounted() {
    this.fetchCategories();
  },
};
</script>

<template>
  <div>
    <h1>Gestion des Catégories</h1>

    <form @submit.prevent="addCategory">
      <input v-model="newCategory.name" placeholder="Nom de la catégorie" required />
      <button type="submit">Ajouter Catégorie</button>
    </form>

    <h2>Liste des Catégories</h2>
    <ul>
      <li v-for="category in categories" :key="category.id">
        {{ category.name }}
        <button @click="deleteCategory(category.id)">Supprimer</button>
      </li>
    </ul>
  </div>
</template>

