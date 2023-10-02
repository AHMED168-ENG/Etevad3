<template>
  <section class="lastimg mt-4 backk">
    <div class="container contain">
      <div class="d-flex flex-column align-items-center gap-3 mb-5">
        <a class="sendd">شركائنا</a>
        <p>نعتز ونفتخر بشراكاتنا المتنوعة والفريدة</p>
      </div>
      <div class="justify-content-center">
        <div class="row gap-5 sh">
          <div style="width: 100%">
            <a
              v-for="sponser in sponsers"
              :key="sponser.description"
              class="col-12 col-md-2 m-3"
              :href="sponser.company_url"
            >
              <img
                :title="sponser.title"
                style="width: 15%"
                class="iml"
                :src="'./images/sponsers/' + sponser.logo"
              />
            </a>
          </div>
        </div>
        <swiper
          :spaceBetween="300"
          :centeredSlides="true"
          :autoplay="{
            delay: 3500,
            disableOnInteraction: false,
          }"
          :navigation="true"
          :modules="modules"
          class="mySwiper"
        >
          <swiper-slide v-for="sponser in sponsers" :key="sponser.id">
            <div class="row gap-5 sh1">
              <div style="width: 100%">
                <a class="col-12 col-md-2 m-3"               
                :href="sponser.company_url"
                  ><img
                  :title="sponser.title"
                    style="width: 40%"
                    :src="'./images/sponsers/' + sponser.logo"
                /></a>
              </div>
            </div>
          </swiper-slide>
        </swiper>
      </div>
    </div>
  </section>
</template>

<script>
import { Swiper, SwiperSlide } from "swiper/vue";
import { Autoplay, Pagination, Navigation } from "swiper/modules";

import "swiper/css";
// import "swiper/css/navigation";
import "swiper/css/pagination";
import { ref } from "vue";
export default {
  components: { Swiper, SwiperSlide },
  data() {
    return {
      sponsers : [],
    }
  },
  setup() {
    return { modules: [Pagination, Autoplay, Navigation] };
  },
  methods : {
  getSponsers() {
    axios
      .get("/sponser/lastSponser")
      .then((res) => {
        if (res.data.status == true) {
          this.sponsers = res.data.sponser;
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
this.getSponsers()
}
};
</script>
<style>
img,
svg {
  vertical-align: bottom !important;
}
.iml {
  filter: grayscale(100%);
}
.iml:hover {
  filter: grayscale(0%);
}
.sendd {
  padding-left: 40px;
  padding-right: 40px;
  padding-top: 2px;
  padding-bottom: 4px;
  border: 2px solid #d2398d;
  border-radius: 24px;
  text-decoration: none;
  color: #d2398d;
  font-weight: bold;
}
.contain {
  margin-top: -150px;
}
.backk {
  background: #e2f4fe;
  clip-path: polygon(0% 0%, 100% 0%, 100% 100%, 0% 100%);
  border-radius: 50% 50% 0% 0%;
  padding-top: 200px;
  padding-bottom: 130px;
}
.sh1 {
  display: none !important;
}
@media only screen and (max-width: 991px) {
  .backk {
    clip-path: polygon(0% 0%, 100% 0%, 100% 100%, 0% 100%);
    border-radius: 0% 0% 0% 0%;
    padding-top: 200px;
    padding-bottom: 130px;
  }
  .sh {
    display: none !important;
  }
  .sh1 {
    display: block !important;
  }
}
</style>
