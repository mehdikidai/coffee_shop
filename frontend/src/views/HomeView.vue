<script setup lang="ts">
import XCover from '@/components/XCover.vue'
import { Splide, SplideSlide } from '@splidejs/vue-splide'
import { ref, watch, onMounted, computed } from 'vue'
import CupImg from '@/assets/imgs/cup-test.jpg'
import { useProductsStore } from '@/stores/products.ts'
import { useCartStore } from '@/stores/cart'

const storeProducts = useProductsStore()
const { addItemToCart, quantityInCart } = useCartStore()
const selectedFilter = ref<number | null>(null)

watch(
  selectedFilter,
  () => {
    storeProducts.fetchProducts(selectedFilter.value)
  },
  { immediate: true },
)

onMounted(() => {
  storeProducts.fetchCategories()
})

const addProductToCart = (productId: number): void => {
  const product = storeProducts.products.find((p) => p.id === productId)

  if (product) {
    addItemToCart({ ...product, quantity: 1 })
  }
}

const filterBy = (filterId: number | null) => {
  selectedFilter.value = filterId === selectedFilter.value ? null : filterId
  console.log(`Filtering by: ${filterId}`)
}

const categories = computed(() => storeProducts.categories )

</script>

<template>
  <layout-app>
    <!-- start cover -->
    <XCover />
    <!-- end cover -->
    <!-- start filter -->
    <div class="filter" v-if="categories">
      <Splide
        :options="{
          autoWidth: true,
          gap: 25,
          padding: 20,
          drag: 'free',
        }"
        aria-label="My Favorite Images"
      >
        <SplideSlide v-for="item in categories" :key="item.id">
          <button
            :class="['filter-btn', { active: selectedFilter === item.id }]"
            @click="filterBy(item.id)"
          >
            {{ item.name }}
          </button>
        </SplideSlide>
      </Splide>

      <!-- end filter -->
    </div>
    <!-- start list items -->

    <x-loading v-if="storeProducts.loading"></x-loading>

    <div v-else class="product-list">
      <div class="product-card" v-for="product in storeProducts.products" :key="product.id">
        <div class="img">
          <small class="quantity" v-if="quantityInCart(product.id) > 0">
            {{ quantityInCart(product.id) }}
          </small>
          <!-- <img :src="CupImg" alt="cup" /> -->
          <img :src="product.photo?.trim() ? product.photo : CupImg" alt="cup" />
          <!-- <img src="https://tea-coffee.ie/data/product/139/gurmans-supreme-coffee-beans-decaf-jpg.jpg" alt="cup" /> -->
        </div>
        <h3>{{ product.name }}</h3>
        <p>{{ product.price }} DH</p>
        <button class="btn-add" @click="addProductToCart(product.id)">
          <x-icon icon="uil:plus" />
        </button>
      </div>
    </div>
  </layout-app>

  <!-- end list items -->
</template>

<style lang="scss" scoped>
.filter {
  background: var(--background-color);
  padding-top: 20px;
  padding-bottom: 0px;
  .filter-btn {
    height: 30px;
    border: none;
    //padding-inline: 24px;
    cursor: pointer;
    font-size: 14px;
    border-radius: 4px;
    text-transform: capitalize;
    font-weight: 400;
    background: transparent;
    color: var(--color-white);
    display: flex;
    align-items: center;
    gap: 6px;
    &.active {
      //background: red;
      color: var(--main-color);
    }
  }
}


.product-list {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));

  gap: 15px;
  padding: 20px;
  .product-card {
    background: var(--background-color-two);
    padding: 10px 10px 20px;
    display: grid;
    gap: 10px;
    border-radius: 6px;
    position: relative;
    .img {
      background: rgba(255, 255, 255, 0.1);
      aspect-ratio: 1;
      clip-path: inset(0 round 2px);
      display: flex;
      position: relative;
      img {
        width: 100%;
        height: 100%;
        object-fit: cover;
      }
      .quantity {
        position: absolute;
        top: 5px;
        right: 5px;
        background: #088549;
        width: 22px;
        height: 22px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 4px;
        font-size: 10px;
        color: var(--color-white);
      }
    }
    h3 {
      color: var(--color-white);
      line-height: 1.4;
      font-size: 14px;
      font-weight: 400;
      text-transform: capitalize;
    }

    p {
      color: var(--color-white);
      opacity: 0.7;
      font-size: 14px;
    }

    .btn-add {
      position: absolute;
      width: 30px;
      height: 30px;
      border: none;
      bottom: 10px;
      right: 10px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      background: var(--main-color);
      svg {
        color: var(--color-white);
        pointer-events: none;
        font-size: 14px;
      }
    }
  }
}
</style>
