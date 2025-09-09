<template>
  <div class="p-4">
    <h1>{{ t('dashboard.title') }}</h1>
    <PosEnabled />
    <div v-if="isInventoryEnabled" class="flex items-center gap-1">
      {{ t('dashboard.stock') }}: {{ stock }}
      <svg class="w-4 h-4 rtl:rotate-180" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
        <path fill-rule="evenodd" d="M10.293 15.707a1 1 0 010-1.414L13.586 11H4a1 1 0 110-2h9.586l-3.293-3.293a1 1 0 111.414-1.414l5 5a1 1 0 010 1.414l-5 5a1 1 0 01-1.414 0z" clip-rule="evenodd" />
      </svg>
    </div>
  </div>
</template>

<script setup>
import { usePage } from '@inertiajs/vue3';
import { useI18n } from 'vue-i18n';
import PosEnabled from '../../Modules/Pos/Enabled.vue';

const { t } = useI18n();
const { props } = usePage();
const isInventoryEnabled = props.isInventoryEnabled;
const stock = props.stock ?? 0;
</script>
