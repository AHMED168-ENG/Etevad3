<template>
  <div
    class="container maine"
    style="
      width: 100%;
      height: 200px;
      background: linear-gradient(270deg, #022c48 0%, #022c48 0%, #306386 100%);
      border-radius: 16px;

      padding-bottom: 360px;
      position: relative;
    "
  >
    <div class="row mainn justify-content-around">
      <div
        v-for="(hero , index) in heros"
        :key="hero.id"
        class="col-md-2 col-5 card"
        :style="{ backgroundColor: color[index] + '!important' } "
      >
        <img
        style="width:176px !important;height:176px !important"
        :src="'./images/heros/' + hero.image"
          alt="Card image cap"
        />
        <div class="card-body">
          <p class="card-tit fw-bold p-2">{{ hero.name }}</p>
          <p class="card-text text-white" style="width: 100%; font-size: 12px" v-html="hero.description"></p>
        </div>
      </div>
    </div>
    <swiper
      :spaceBetween="30"
      :centeredSlides="true"
      :autoplay="{
        delay: 2500,
        disableOnInteraction: false,
      }"
      :navigation="true"
      :modules="modules"
      class="response"
    >
      <swiper-slide v-for="hero in heros" :key="hero.id">
        <div class="row justify-content-around mt-5">
          <img
            class="tablet"
            style="width: 40%"
            :src="'./images/heros/' + hero.image"
            alt="Card image cap"
          />
          <div class="mt-4">
            <p class="card-tit fw-bold p-2">{{ hero.name }}</p>
            <p class="card-text text-white" style="margin:0 !important" v-html="hero.description"></p>
          </div>
          <div class="col-md-2 col-5" style=""></div>
        </div>
      </swiper-slide>
    </swiper>
    <router-link
      :to="{ name: 'heroes' }"
      style="
        text-align: left;
        color: rgb(255, 255, 255);
        bottom: 0;
        position: absolute;
        bottom: 0;
        left: 0;
        padding-left: 34px;
        line-height: 50px;
        text-align: left;
        color: #ffffff;
      "
      ><p class="fw-bold">المزيد ..</p></router-link
    >
  </div>
</template>
<style scoped>
.card {
  width: 200px;
  height: 170px;
  border-radius: 35px !important;
  margin-top: -6%;
  background:none
}
.main-card p {
  width: 80%;
}
.card-tit {
  margin-top: -30px;
  background: white;
  border-radius: 24px;
  justify-content: center;
  align-items: center;
  gap: 16px;
  top: 190px;
  margin-right: 10px;
  box-shadow: 0px 4px 4px rgba(162.56, 162.56, 162.56, 0.25);
}
@media only screen and (max-width: 991px) {
  .maine {
    width: 95% !important;
  }
}
/* .respo {
  display: none;
} */
</style>
<script>
import { Swiper, SwiperSlide } from "swiper/vue";
import { Autoplay, Pagination, Navigation } from "swiper/modules";

import "swiper/css";
// import "swiper/css/navigation";
import "swiper/css/pagination";
export default {
  data() {
    return {
      heros : [],
      color:["#62ccfc" , "#ffdcb2" , "#b2faff" , "#c4bcf4"]
    }
  },
  components: { Swiper, SwiperSlide },
  setup() {
    return { modules: [Pagination, Autoplay, Navigation]};
  },
  methods : {

    getHeros() {
      axios
        .get("/hero/lastHeros")
        .then((res) => {
          if (res.data.status == true) {
            this.heros = res.data.hero;
            console.log("*".repeat(20))
            console.log(res)
            console.log("*".repeat(20))
          } else if (res.data.status == null) {
            Toast.fire({
              icon: "error",
              title: res.data.error,
            });
          }
        })
        .catch((error) => {
          Toast.fire({
            icon: "error",
            title: error,
          });
        });
    },
  },
  created() {
    this.getHeros()
  }
};
</script>
<style>
.response {
  display: none !important;
}

@media only screen and (max-width: 991px) {
  .response {
    display: block !important;
  }
  .mainn {
    display: none !important;
  }
}
@media only screen and (min-width: 700px) and (max-width: 800px) {
  .tablet {
    width: 30% !important;
  }
}
</style>
