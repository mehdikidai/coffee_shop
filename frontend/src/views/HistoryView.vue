<template>
  <layout-app>
    <div class="boxes">
      <div class="box" v-for="(item, i) in storeCart.ordersHistory" :key="i">
        <div class="bx name_and_date">
          <h2> <span> {{ item.quantity }} </span>{{ item.name }} <span class="x">x</span> <span>{{ item.price }}</span></h2>
          <span class="date">{{ moment(item.createdAt).format('hh:mm') }}</span>
        </div>
        <div class="bx price">
          <span >{{ item.price * item.quantity }} {{ currency }}</span>
        </div>
      </div>
    </div>
  </layout-app>
</template>

<script setup lang="ts">
import { useCartStore } from '@/stores/cart'
import { onMounted } from 'vue'
import moment from 'moment'

const currency = import.meta.env.VITE_CURRENCY

const storeCart = useCartStore()

onMounted(async () => {
  console.log(await storeCart.getOrders())
})
</script>

<style scoped lang="scss">
.boxes {
  display: grid;
  padding: 20px 20px;
  .box {
    background: var(--background-color-two);
    height: 60px;
    display: grid;
    grid-template-columns: 1fr 70px;
    gap: 10px;
    &:first-child {
      clip-path: inset(0 round 6px 6px 0 0);
    }

    &:last-child {
      clip-path: inset(0 round 0 0 6px 6px);
    }
    &:not(:last-child) {
      border-bottom: 1px dashed rgba(255, 255, 255, 0.2);
    }
    .bx {
      display: flex;
      flex-direction: column;
      justify-content: center;
      gap: 4px;
      &.name_and_date {
        padding-inline: 20px;
        h2 {
          font-size: 14px;
          font-weight: 500;
          color: var(--color-white);
          text-transform: capitalize;
          display: flex;
          align-items: flex-end;
          gap: 4px;
          line-height: 1;
          .x{
            opacity: 0.5;
            font-size: 12px;
            height: fit-content;
            line-height: 1;
          }
        }
        span.date {
          font-size: 12px;
          color: var(--color-white);
          opacity: 0.5;
        }
      }
      &.price {
        align-items: center;
        span {
          color: var(--main-color);
          opacity: 0.9;
          font-size: 14px;
          text-transform: capitalize;
        }
      }
    }
  }
}
</style>
