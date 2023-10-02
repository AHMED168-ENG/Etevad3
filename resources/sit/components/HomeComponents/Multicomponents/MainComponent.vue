<template>
  <div>
    <section class="container mb-5 pt-4">
      <div class="d-flex flex-column align-items-center gap-4">
        <div>
          <router-link :to="{ name: 'achievemnet' }" class="senddd"
            >البطولات</router-link
          >
        </div>
        <div class="mb-2" style="position: relative">
          <img
            class="response"
            src="../../../assets/photos/Group_15.svg"
            style="position: absolute; right: 55px; top: 35px; width: 70px"
          />
          <h3 class="mb-3" style="color: #306386; font-weight: bold">
            أجواء بطولاتنا لا تنتهي
          </h3>
          <p
            style="font-size: 16px; line-height: 22px; width: 70%; margin: auto"
          >
            ودك تعرف أكثر عن بطولاتنا اللي نقدمها في الاتحاد تعال ناخدك بجوله
          </p>
        </div>
        <div
          class="d-flex text-center justify-contnet-center"
          style="background: #e2f4fe; border-radius: 20px; overflow: hidden"
        >
          <a class="linkk" :class="activee" @click="FirstCompo">الروبوت</a>
          <a class="linkk2" :class="active1" @click="SecCompo"
            >الرياضات اللاسلكية</a
          >
        </div>
      </div>
    </section>
    <div class="pb-1">
      <FirstCompon v-show="FirstCompon" />
      <SecCompon v-show="SecCompon" />
    </div>
  </div>
</template>

<style scoped>
.response {
  display: block !important;
}
.linkk,
.linkk2 {
  text-decoration: none;
  color: black;
  margin: 2px;
  cursor: pointer;
  padding: 4px;
  width: 200px;
}
.active {
  color: #d2398d;
  border: 2px solid #d2398d;

  border-radius: 20px;

  align-items: center;
}

a {
  text-decoration: none !important;
}

@media only screen and (max-width: 991px) {
  .response {
    display: none !important;
  }
  .active {
    color: #d2398d !important;
  }
  .linkk,
  .linkk2 {
    text-decoration: none;
    color: black;
    margin: 2px;
    cursor: pointer;
    padding: 4px;
    width: 150px;
  }
}
</style>

<script>
import FirstCompon from "../../../components/HomeComponents/Multicomponents/FirstCompon.vue";

import SecCompon from "../../../components/HomeComponents/Multicomponents/SecCompon.vue";

export default {
  data() {
    return {
      FirstCompon: true,
      SecCompon: false,
      activee: "active",
      active1: "",
    };
  },
  components: {
    SecCompon,
    FirstCompon,
  },
  methods: {
    FirstCompo() {
      this.FirstCompon = true;
      this.SecCompon = false;
      this.activee = "active";
      this.active1 = "";
    },
    SecCompo() {
      this.SecCompon = true;
      this.FirstCompon = false;
      this.activee = "";
      this.active1 = "active";
    },
  },
};
</script>
