<template>
  <div>
      <div class="Section">
        <div class="container">
          <div class="row align-items-center mt-5 mb-5">
            <div class="col-12 col-md-6 mb-5">
              <div style="position: relative">
                <img
                  :src="'./images/news/' + AllNews[0]?.image"
                  style="width: 100%"
                />
              </div>
            </div>
            <div class="col-12 col-md-6">
              <div style="text-align: justify; margin-bottom: 100px">
                <h3 class="fw-bold mb-3" style="line-height: 50px width: 60%">
                  {{ AllNews[0]?.title }}
                </h3>
                <hr />
                <p class="mb-2" v-html="AllNews[0]?.full_description">
                  
                </p>
              </div>

              <div class="d-flex justify-content-between text-white mt-5">
                <div>
                  <img src="../../assets/photos/Vector.svg" /> {{ formateDate(AllNews[0]?.news_date).date + " " + formateDate(AllNews[0]?.news_date).day }} 
                </div>
                <div>
                  <router-link
                    :to="{ name: 'news' }"
                    style="line-height: 50px; padding-left: 30px; color: #d2398d"
                    ><p class="fw-bold">المزيد ..</p></router-link
                  >
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="container">
        <swiper
          :spaceBetween="30"
          :centeredSlides="true"
          :autoplay="{
            delay: 2500,
            disableOnInteraction: false,
          }"
          :navigation="true"
          :modules="modules"
          class="mySwiper"
        >
          <swiper-slide v-for="news in AllNews?.slice(1)" :key="news.id">
            <div class="container row justify-content-center gap-3 mt-5">
              <div
                v-for="news in AllNews?.slice(1)"
                :key="news.id"
                class="card col-12 col-md-6 crd resp"
                style="
                  width: 30%;
                  background: white;
                  box-shadow: 0px 4px 4px rgba(162.56, 162.56, 162.56, 0.25);
                  border-radius: 16px !important;
                  color: #306386;
                "
              >
                <img
                  class="card-img-top"
                  :src="'./images/news/' + news.image"
                  alt="Card image cap"
                />
                <div class="card-body">
                  <p class="card-text fw-bold" style="text-align: right">
                    {{ news.title }}
                  </p>
                  <hr />
                  <div style="float: right">
                    <img src="../../assets/photos/Vector2.svg" />
                    <span> {{ formateDate(news.news_date).date + " " + formateDate(news.news_date).day }}</span>
                  </div>
                </div>
              </div>
              <div
                class="card col-12 col-md-6 crdd"
                style="
                  width: 100%;
                  background: white;
                  box-shadow: 0px 4px 4px rgba(162.56, 162.56, 162.56, 0.25);
                  border-radius: 16px !important;
                  color: #306386;
                "
              >
                <img
                  class="card-img-top"
                  :src="'./images/news/' + news.image"
                  alt="Card image cap"
                />
                <div class="card-body">
                  <p class="card-text fw-bold" style="text-align: right">
                    {{ news.title }}
                  </p>
                  <hr />
                  <div style="float: right">
                    <img src="../../assets/photos/Vector2.svg" />
                    <span> {{ formateDate(news.news_date).date + " " + formateDate(news.news_date).day }}</span>
                  </div>
                </div>
              </div>
            </div>
          </swiper-slide>
        </swiper>
      </div>
      <VPagination
        v-model="page"
        :pages="data.last_page"
        :range-size="1"
        active-color="#DCEDFF"
        align="center"
        @update:modelValue="getNews"
      ></VPagination>
  </div>
</template>
<script>
import { Swiper, SwiperSlide } from "swiper/vue";
import { Autoplay, Pagination, Navigation } from "swiper/modules";

import "swiper/css";
// import "swiper/css/navigation";
import "swiper/css/pagination";
export default {
  data() {
    return {
      AllNews : [],
      page:1,
      data:{}
    }
  },
  methods : {
    formateDate(date) {
      return {
        day: moment(date).format("dddd"),
        date: moment(date).format("L"),
        time: moment(date).format(" h:mm:ss a"),
      };
    },
    getNews(page = this.page) {
      axios
        .get("/news/ActiveNews?page=" + page)
        .then((res) => {
          if (res.data.status == true) {
            this.AllNews = res.data.news.data;
            this.data = res.data.news;
            console.log(res)
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
    this.getNews()
  },
  components: { Swiper, SwiperSlide },
  setup() {
    return { modules: [Pagination, Autoplay, Navigation] };
  },
};
</script>
<style>
.Pagination {
  justify-content: center;
  margin:20px 0 !important
}
.crdd {
  display: none !important;
}
@media only screen and (max-width: 991px) {
  .crd {
    width: 100% !important;
  }
  .resp {
    display: none !important;
  }
  .crdd {
    display: block !important;
  }
}
</style>
