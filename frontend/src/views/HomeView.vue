<script setup lang="ts">
import XCover from '@/components/XCover.vue'
import { Splide, SplideSlide } from '@splidejs/vue-splide'
import { ref, watch, onMounted } from 'vue'
import CupImg from '@/assets/imgs/cup-test.jpg'
import { useProductsStore } from '@/stores/products.ts'
import { useCartStore } from '@/stores/cart'
import { toast } from 'vue3-toastify'

const storeProducts = useProductsStore()
const cartStore = useCartStore()

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
    cartStore.addItemToCart({ ...product, quantity: 1 })
    toast.success(`It has been added : ${product.name}`, {
      position: 'top-center',
      theme: 'dark',
      hideProgressBar: true,
      transition: 'slide',
      autoClose: 300,
    })
  }
}

const filterBy = (filterId: number | null) => {
  selectedFilter.value = filterId === selectedFilter.value ? null : filterId
  console.log(`Filtering by: ${filterId}`)
}
</script>

<template>
  <!-- start cover -->

  <XCover />

  <!-- end cover -->

  <!-- start filter -->

  <div class="filter">
    <Splide
      :options="{
        autoWidth: true,
        gap: 10,
        padding: 20,
        drag: 'free',
      }"
      aria-label="My Favorite Images"
    >
      <SplideSlide v-for="item in storeProducts.categories" :key="item.id">
        <button
          :class="['filter-btn', { active: selectedFilter === item.id }]"
          @click="filterBy(item.id)"
        >
          <x-icon :icon="item.icon"></x-icon> {{ item.name }}
        </button>
      </SplideSlide>
    </Splide>

    <!-- end filter -->
  </div>
  <!-- start list items -->

  <div class="loading-box" v-if="storeProducts.loading">
    <x-icon icon="svg-spinners:bars-rotate-fade"></x-icon>
  </div>

  <div v-else class="product-list">
    <div class="product-card" v-for="product in storeProducts.products" :key="product.id">
      <div class="img">
        <img :src="CupImg" alt="cup" />
      </div>
      <h3>{{ product.name }}</h3>
      <p>{{ product.price }} DH</p>
      <button class="btn-add" @click="addProductToCart(product.id)">
        <x-icon icon="uil:plus" />
      </button>
    </div>
  </div>

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
    padding-inline: 24px;
    cursor: pointer;
    font-size: 14px;
    border-radius: 4px;
    text-transform: capitalize;
    font-weight: 400;
    background: var(--color-white);
    color: var(--color-text);
    display: flex;
    align-items: center;
    gap: 6px;
    &.active {
      background: var(--main-color);
      color: var(--color-white);
    }
  }
}

.loading-box {
  min-height: 200px;
  display: flex;
  align-items: center;
  justify-content: center;
  svg {
    color: var(--color-white);
    font-size: 20px;
    opacity: 0.5;
  }
}

.product-list {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));

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
      img {
        width: 100%;
        height: 100%;
        object-fit: cover;
      }
    }
    h3 {
      color: var(--color-white);
      line-height: 1.4;
      font-size: 14px;
      font-weight: 400;
    }

    p {
      color: var(--color-white);
      opacity: 0.7;
    }

    .btn-add {
      position: absolute;
      width: 28px;
      height: 28px;
      border: none;
      bottom: 10px;
      right: 10px;
      border-radius: 14px;
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      background: var(--main-color);
      svg {
        color: var(--color-white);
      }
    }
  }
}
</style>
