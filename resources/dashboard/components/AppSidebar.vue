<template>
  <CSidebar
    position="fixed"
    :unfoldable="sidebarUnfoldable"
    :visible="sidebarVisible"
    @visible-change="
      (event) =>
        $store.commit({
          type: 'updateSidebarVisible',
          value: event,
        })
    "
  >
    <router-link to="/">
      <CSidebarBrand>
        <img style="width: 70%" :src="'./images/seting/' + seting.site_lower_logo" alt="" />
      </CSidebarBrand>
    </router-link>
    <AppSidebarNav />
    <CSidebarToggler
      class="d-none d-lg-flex"
      @click="$store.commit('toggleUnfoldable')"
    />
  </CSidebar>
</template>

<script>
import { computed } from "vue";
import { useStore } from "vuex";
import { AppSidebarNav } from "./AppSidebarNav";
import { logoNegative } from "../assets/brand/logo-negative";
import { sygnet } from "../assets/brand/sygnet";
export default {
  name: "AppSidebar",
  components: {
    AppSidebarNav,
  },
  data() {
    return {
      seting : {}
    }
  },
  setup() {
    const store = useStore();
    return {
      logoNegative,
      sygnet,
      sidebarUnfoldable: computed(() => store.state.sidebarUnfoldable),
      sidebarVisible: computed(() => store.state.sidebarVisible),
    };
  },
  created() {
    this.seting = this.$store.getters.getSeting
  }
};
</script>
