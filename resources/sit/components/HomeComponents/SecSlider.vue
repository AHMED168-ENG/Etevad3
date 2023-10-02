<template>
  <section
    style="
      position: relative;
      background: linear-gradient(
        180deg,
        #a7e5ff 0%,
        rgba(255, 255, 255, 0) 100%
      );
    "
  >
    <div class="container back1">
      <div class="d-flex justify-content-between align-items-center mb-4">
        <div style="margin-top: 35px">
          <router-link :to="{ name: 'achievemnet' }" class="senddd"
            >الإنجازات والتكريمات</router-link
          >
        </div>
        <div class="d-flex align-items-center justify-content-center mt-5">
          <a class="swiper-button-prev">
            <img
              class="size btnn"
              src="../../assets/photos/leftarrrow.svg"
              style="filter: opacity(50%); transform: scaleX(-1)"
            />
          </a>
          <a class="swiper-button-next swiper-button">
            <img
              class="size btnn"
              src="../../assets/photos/leftarrrow.svg"
              style="filter: opacity(50%)"
            />
          </a>
        </div>
      </div>
      <div class="">
        <swiper
          :spaceBetween="100"
          :centeredSlides="true"
          :pagination="{
            clickable: true,
          }"
          :autoplay="{
            delay: 2500,
            disableOnInteraction: false,
          }"
          :navigation="{
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
            clickable: true,
          }"
          :modules="modules"
          class="mySwiper"
        >
          <swiper-slide
            v-for="achivement in AllAchivement"
            :key="achivement.id"
          >
            <div class="row justify-content-center">
              <div class="col-12 col-lg-6 mb-4">
                <div class="colstyle" style="text-align: justify; width: 60%">
                  <h3 class="fw-bold mb-3 title" style="line-height: 50px">
                    {{ achivement.title }}
                  </h3>
                  <hr class="line" />
                  <p class="mb-4" v-html="achivement.content"></p>
                  <a
                    class="mgroup"
                    style="
                      float: right;
                      color: deeppink;
                      background-color: #b2e3ff;
                      border-radius: 24px;
                      padding: 5px 35px 5px 35px;
                    "
                    ><img
                      style="width: 32px; height: 32px; object-fit: content"
                      :src="
                        './images/achivement/icons/' +
                        achivement.achivement_icon
                      "
                    />
                    انجاز {{ achivement.achivement_kind }}
                  </a>
                </div>
              </div>
              <div class="col-12 col-lg-6">
                <div style="position: relative">
                  <img
                    :src="
                      './images/achivement/images/' +
                      achivement.achivement_image
                    "
                    style="width: 100%"
                  />

                  <div class="sticker">
                    <img src="../../assets/photos/Vector_6.svg" />
                    <h5 class="fw-bold text-white" style="margin-top: -70px">
                      {{ formateDate(achivement.achivement_date).year }}
                    </h5>
                  </div>
                </div>
              </div>
            </div>
          </swiper-slide>
        </swiper>
      </div>
      <router-link
        :to="{ name: 'achievemnet' }"
        style="text-align: left; line-height: 50px; color: #d2398d"
        ><p class="fw-bold more">المزيد ..</p></router-link
      >
    </div>
  </section>
</template>

<script>
import { Swiper, SwiperSlide } from "swiper/vue";
import { Autoplay, Pagination, Navigation } from "swiper/modules";

import "swiper/css";
// import "swiper/css/navigation";
import "swiper/css/pagination";
import { useSwiper } from "swiper/vue";

export default {
  components: { Swiper, SwiperSlide },
  data() {
    return {
      page: 0,
      AllAchivement: [],
    };
  },
  setup() {
    const swiper = useSwiper();

    return {
      swiper,
      modules: [Pagination, Autoplay, Navigation],
    };
  },

  methods: {
    getAchivement() {
      axios
        .get("/achivement/lastThree")
        .then((res) => {
          if (res.data.status == true) {
            this.AllAchivement = res.data.lastThreeAchivement;
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
    formateDate(date) {
      return {
        year: moment(date).format("YYYY"),
        date: moment(date).format("L"),
        time: moment(date).format(" h:mm:ss a"),
      };
    },
  },
  created() {
    this.getAchivement();
  },
};
</script>

<style scoped>
.btnn:hover {
  filter: opacity(100%) !important;
}
.title {
  color: #306386;
  font-size: 35px;
}
.sticker {
  position: absolute;
  top: 0;
  left: 240px;
  width: 100%;
  height: 100%;

  border-radius: 50%;
}
.swiper {
  margin-left: auto;
  margin-right: auto;
  position: relative;

  overflow: clip;
  list-style: none;
  padding: 0;
  z-index: 1;
  display: block;
  padding-bottom: 40px;
}
.swiper-pagination-bullet {
  width: 14px !important;
  height: 14px !important;
  display: inline-block !important;
  border-radius: 50% !important;
  background: red !important;
  opacity: 0.2 !important;
}

.back1 {
  background-image: url("../../assets/photos/back_1.svg");
  background-repeat: no-repeat;
  background-size: cover;
  padding-bottom: 10px;
}

@media only screen and (min-width: 700px) and(max-width: 800px) {
  .sticker {
    position: absolute;
    top: -55px !important;
    left: 235px !important;
    width: 100%;
    height: 100%;

    transform: scale(70%);

    border-radius: 50%;
  }
}
@media only screen and (max-width: 700px) {
  .senddd {
    padding-left: 10px !important;
    padding-right: 10px !important;
  }
  .title {
    color: #306386;
    scale: 85%;
    transform: translate(34px);
    text-align: right;
  }

  .back1 {
    margin-top: 0px;
  }
  .size {
    width: 30px;
  }
  .colstyle {
    width: 100% !important;
  }
  .line {
    display: none;
  }
  .more {
    display: none;
  }
  .sticker {
    position: absolute;
    top: -36px;
    left: 120px;
    width: 100%;
    height: 100%;

    transform: scale(70%);

    border-radius: 50%;
  }
  .mgroup {
    margin-bottom: 8px;
  }
}
</style>
