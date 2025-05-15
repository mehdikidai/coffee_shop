<template>
  <div
    class="line"
    :style="{
      borderBottom: `1px ${borderStyle} rgba(255, 255, 255, 0.2)`,
    }"
  ></div>
</template>

<script setup lang="ts">
const { borderStyle = 'dashed' } = defineProps<{ borderStyle?: string }>()
</script>

<style scoped lang="scss">
.line {
  margin: 0 auto;
  height: 1px;
  width: 100%;
  margin-block: 20px;
}
</style>
