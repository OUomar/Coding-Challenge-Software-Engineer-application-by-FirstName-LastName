<script>
import axios from "axios";
import Modal from '../Modal.vue';
import { ROUTES } from '@/router/routes.js';

export default {
  components: {
    Modal,
  },
  mounted() {
    this.fetchProducts();
  },
  data() {
    return {
      newProduct: {
        name: "",
        description: "",
        price: null,
        image: null,
        categories: [],
      },
      products: [],
      currentPage: 1,
      itemsPerPage: 5,
      totalItems: 10,
      sortBy: "name",
      sortOrder: "asc",
      allCategories: [],
      categoryFilter: "", 
      showModal: false,
      selectedProduct: null, 
    };
  },
  computed: {
    paginatedProducts() {
      const start = (this.currentPage - 1) * this.itemsPerPage;
      return this.products
        .sort((a, b) => {
          const modifier = this.sortOrder === "asc" ? 1 : -1;
          return a[this.sortBy] > b[this.sortBy] ? modifier : -modifier;
        })
        .slice(start, start + this.itemsPerPage);
    },
    totalPages() {
      return Math.ceil(this.totalItems / this.itemsPerPage);
    },
  },
  methods: {
  //Add produit 
    async addProduct() {
      const formData = new FormData();
      formData.append("name", this.newProduct.name);
      formData.append("description", this.newProduct.description);
      formData.append("price", this.newProduct.price);
      formData.append("image", this.newProduct.image);
      
      this.newProduct.categories.forEach((categoryId) => {
        formData.append("categories[]", categoryId); // Ajouter les catégories comme un tableau
      });

      try {
        await axios.post(ROUTES.PRODUCTS, formData);
        this.fetchProducts();
        this.newProduct = { name: "", description: "", price: null, image: null, categories: [] }; // Réinitialiser les catégories
      } catch (error) {
        console.error("Erreur lors de l'ajout du produit :", error.response.data);
        alert("Erreur lors de l'ajout du produit : " + (error.response.data.message || "Veuillez réessayer."));
      }
    },
    //display produit 
    async fetchProducts() {
      try {
        const response = await axios.get(ROUTES.PRODUCTS, {
          params: {
            sort_by: this.sortBy,
            sort_order: this.sortOrder,
            page: this.currentPage,
            per_page: this.itemsPerPage,
            category_id: this.categoryFilter, 
          },
        });
        this.products = response.data.data;
        this.totalItems = response.data.total;
      } catch (error) {
        console.error("Error fetching products:", error);
      }
    },
     //display categories 
    async fetchCategories() {
      try {
        const response = await axios.get(ROUTES.CATEGORIES);
        console.log(response);
        this.allCategories = response.data;
      } catch (error) {
        console.error("Error fetching categories:", error);
      }
    },
     //delete produit 
    async deleteProduct(id) {
      if (confirm("Êtes-vous sûr de vouloir supprimer ce produit?")) {
        await axios.delete(`${ROUTES.PRODUCTS}/${id}`);
        this.fetchProducts();
      }
    },
    onFileChange(event) {
      this.newProduct.image = event.target.files[0];
    },
    prevPage() {
      if (this.currentPage > 1) {
        this.currentPage--;
        this.fetchProducts();
      }
    },
    nextPage() {
      if (this.currentPage < this.totalPages) {
        this.currentPage++;
        this.fetchProducts();
      }
    },
    openModal(product) {
      this.selectedProduct = product;
      this.showModal = true;
    },
    closeModal() {
      this.showModal = false;
      this.selectedProduct = null;
    },
  },
  created() {
    this.fetchCategories(); // Récupérer les catégories lors de la création du composant
  },
};
</script>
<template>
  <div>
    <h1>Gestion des Produits</h1>
    <form @submit.prevent="addProduct" class="product-form">
            <input v-model="newProduct.name"  class="custom-input" placeholder="Nom du produit" required />
            <input v-model="newProduct.description" class="custom-input" placeholder="Description" />
            <input v-model="newProduct.price" type="number" class="custom-input" placeholder="Prix" required />
            <input type="file"  class="product-name-input" @change="onFileChange" />
             <select v-model="newProduct.categories" multiple>
                <option v-for="category in allCategories" :key="category.id" :value="category.id">{{ category.name }}</option>
            </select>
            <button type="submit" class="custom-btn">Ajouter Produit</button>
    </form>
    <h2>Liste des Produits</h2>
    <!-- Ajout d'un filtre par catégorie -->
    <label for="categoryFilter">Filtrer par catégorie :</label>
    <select v-model="categoryFilter" @change="fetchProducts">
      <option value="">Tous</option>
      <option v-for="category in allCategories" :key="category.id" :value="category.id">{{ category.name }}</option>
    </select>
    <div>
      <label for="sort">Trier par :</label>
      <select v-model="sortBy">
        <option value="name">Nom</option>
        <option value="price">Prix</option>
      </select>
      <select v-model="sortOrder">
        <option value="asc">Ascendant</option>
        <option value="desc">Descendant</option>
      </select>
    </div>
    <ul>
      <li v-for="product in paginatedProducts" :key="product.id">
        <img v-if="product.image_url" :src="product.image_url" alt="Image du produit" />
        <span @click="openModal(product)">{{ product.name }} - {{ product.price }} €</span>
        <button @click="deleteProduct(product.id)">Supprimer</button>
      </li>
    </ul>
    <div class="pagination">
      <button @click="prevPage" :disabled="currentPage === 1">Précédent</button>
      <span>Page {{ currentPage }} sur {{ totalPages }}</span>
      <button @click="nextPage" :disabled="currentPage === totalPages">Suivant</button>
    </div>
    <!-- Modal pour afficher les détails du produit -->
    <Modal v-if="showModal" :show="showModal" :product="selectedProduct" @close="closeModal" />
  </div>
</template>



<style scoped>
.pagination {
  display: flex;
  justify-content: center;
  margin-top: 20px;
}
.error {
  color: red;
}

/* Formulaire */
.product-form {
    display: flex;
    flex-direction: column;
    gap: 10px;
    margin-bottom: 20px;
}

input[type="text"], input[type="number"], input[type="file"] {
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
}

/* Style pour le bouton */
.custom-btn {
    background-color: #2e6bc2; 
    color: white;
    padding: 15px 30px; 
    font-size: 16px; 
    border: none; 
    border-radius: 8px;
    cursor: pointer; 
    box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1); 
    text-transform: uppercase; 
    transition: background-color 0.3s ease, box-shadow 0.3s ease; 
    width: 100%; 
}

/* Style au survol (hover) */
.custom-btn:hover {
    background-color: #1f4e91; 
    box-shadow: 0px 6px 10px rgba(0, 0, 0, 0.2); 
}

.custom-input {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px; 
    font-size: 16px;
    color: #333;
    background-color: #fff; 
    box-shadow: none;
    transition: border-color 0.2s ease-in-out;
}

.custom-input:focus {
    border-color: #007bff; 
    outline: none;
}
/* Style pour le sélecteur */
.custom-select {
    width: 100%;
    padding: 10px; 
    border: 1px solid #ddd; 
    border-radius: 5px;
    background-color: #fff; 
    font-size: 16px; 
    outline: none; 
    transition: border-color 0.3s; 
}

.custom-select:focus {
    border-color: #007bff; 
    box-shadow: 0 0 5px rgba(0, 123, 255, 0.5); 
}
.custom-select option {
    padding: 10px; 
}

.custom-select[multiple] {
    height: auto; 
    min-height: 100px; 
    overflow-y: auto; 
}
</style>
