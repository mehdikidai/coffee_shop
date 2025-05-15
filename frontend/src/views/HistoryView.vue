<template>
  <layout-app>
    <div class="boxes" v-if="storeCart.ordersHistory.length > 0">
      <div class="box" v-for="(item, i) in storeCart.ordersHistory" :key="i">
        <div class="bx name_and_date">
          <h2>
            <span> {{ item.quantity }} </span>{{ item.name }} <span class="x">x</span>
            <span>{{ item.price }}</span>
          </h2>
          <small class="order-id">
            order : <button @click="showOrder(item.orderId)">#{{ item.orderId }}</button></small
          >
          <span class="date">hour : {{ moment(item.createdAt).format('hh:mm') }}</span>
        </div>
        <div class="bx price">
          <span>{{ item.price * item.quantity }} {{ currency }}</span>
        </div>
      </div>
      <div class="total">
        <span>total :</span>
        <span>{{ storeCart.totalSales }} {{ currency }}</span>
      </div>
    </div>
    <x-loading v-else-if="storeCart.loadingHistory"></x-loading>
    <x-empty v-else message="No orders recorded today." icon="uil:clipboard-notes"></x-empty>
  </layout-app>
</template>

<script setup lang="ts">
import { useCartStore } from '@/stores/cart'
import { onMounted } from 'vue'
import moment from 'moment'
import XEmpty from '@/components/XEmpty.vue'

const currency = import.meta.env.VITE_CURRENCY
const storeCart = useCartStore()

onMounted(async () => {
  console.log(await storeCart.getOrders())
})

const showOrder = (id: number) => {
  alert(id)
}
</script>

<style scoped lang="scss">
.boxes {
  display: grid;
  padding: 20px 20px;

  .box {
    background: transparent;
    height: 80px;
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
        padding-inline: 0px;
        h2 {
          font-size: 14px;
          font-weight: 500;
          color: var(--color-white);
          text-transform: capitalize;
          display: flex;
          align-items: flex-end;
          gap: 4px;
          line-height: 1;
          .x {
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
          text-transform: capitalize;
        }
        small.order-id {
          font-size: 12px;
          color: var(--color-white);
          opacity: 0.7;
          text-transform: capitalize;
          button {
            color: var(--main-color);
            background: transparent;
            border: none;
            cursor: pointer;

          }
        }
      }
      &.price {
        align-items: flex-end;
        span {
          color: var(--main-color);
          opacity: 0.9;
          font-size: 14px;
          text-transform: capitalize;
        }
      }
    }
  }

  .total {
    background: var(--background-color-two);
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-inline: 15px;
    height: 44px;
    border-radius: 4px;
    margin-block: 20px;
    span {
      text-transform: capitalize;
      color: var(--color-white);
    }
  }
}
</style>
