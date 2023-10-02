<template>
  <div>
    <section class="container mb-5">
      <div
        class="d-flex flex-column align-items-center gap-4 container pt-5 back"
      >
        <div>
          <router-link
            :to="{ name: 'motivatcover', params: { ico: 'coverage' } }"
            class="senddd"
            >تغطيات خاصة</router-link
          >
        </div>
        <div class="mb-2" style="position: relative">
          <img
            class="shp"
            src="../../assets/photos/Group_15.svg"
            style="position: absolute; right: 10px; top: 35px; width: 70px"
          />
          <h3 class="title">حماس وتحدي لا ينتهي</h3>
          <p
            style="font-size: 16px; line-height: 30px; width: 70%; margin: auto"
          >
            عش اجواء بطولاتنا وفعاليتنا مع تغطية مختصرة وسريعة
          </p>
        </div>
      </div>
      <div>
        <div class="row justify-content-between align-items-center">
          <div class="col-12 col-md-12 col-lg-6">
            <div class="mb-4" style="position: relative">
              <iframe
                class="vid"
                width="100%"
                height="250px"
                :src="
                  'https://www.youtube.com/embed/' + (AllCoverage[0] ? AllCoverage[0].video_id : '')
                "
                title="YouTube video player"
                frameborder="0"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                allowfullscreen
              ></iframe>
            </div>
          </div>
          <div class="col-12 col-md-12 col-lg-6 align-items-center">
         
            <swiper
              :spaceBetween="0"
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
              class="mySwiper pb-4"
            > 
            <swiper-slide
                v-for="(coverage,index) in (AllCoverage.length ? Math.ceil(AllCoverage.length / 2) : AllCoverage)"
                :key="coverage.id"
              >
                <div
                  class="row align-items-center gap-2 justify-content-center mb-3"
                >
                  <div
                    v-if="AllCoverage[index + (index == 0 ? 0 : 1)]"
                    class="col-6 card"
                    style="
                      background: #ffffff;
                      box-shadow: 0px 4px 4px rgba(162.56, 162.56, 162.56, 0.25);
                      border-radius: 16px !important;
                    "
                  >
                    <iframe
                      class="vid"
                      width="100%"
                      :src="
                        'https://www.youtube.com/embed/' + AllCoverage[index + (index == 0 ? 0 : 1)].video_id
                      "
                      title="YouTube video player"
                      frameborder="0"
                      allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                      allowfullscreen
                    ></iframe>
                    <div class="card-body">
                      <p
                        class="card-text fw-bold"
                        style="
                          text-align: right;
                          font-size: 12px;
                          color: #306386;
                        "
                      >
                        {{ AllCoverage[index + (index == 0 ? 0 : 1) ].title }}
                      </p>

                      <div class="day mt-1" style="float: right">
                        <img src="../../assets/photos/Vector2.svg" />
                        <span style="font-size: 12px">
                          {{ formateDate(AllCoverage[index + (index == 0 ? 0 : 1) ].coverage_date).date }}
                          {{ formateDate(AllCoverage[index + (index == 0 ? 0 : 1) ].coverage_date).day }}</span
                        >
                      </div>
                    </div>
                  </div>
                  <div
                  v-if="AllCoverage[index + (index == 0 ? 1 : 2)]"
                    class="col-6 card"
                    style="
                      background: #ffffff;
                      box-shadow: 0px 4px 4px rgba(162.56, 162.56, 162.56, 0.25);
                      border-radius: 16px !important;
                    "
                  >
                    <iframe
                      class="vid"
                      width="100%"
                      :src="
                        'https://www.youtube.com/embed/' + AllCoverage[index + (index == 0 ? 1 : 2)].video_id
                      "
                      title="YouTube video player"
                      frameborder="0"
                      allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                      allowfullscreen
                    ></iframe>
                    <div class="card-body">
                      <p
                        class="card-text fw-bold"
                        style="
                          text-align: right;
                          font-size: 12px;
                          color: #306386;
                        "
                      >
                        {{  AllCoverage[index + (index == 0 ? 1 : 2)].title }}
                      </p>

                      <div class="day mt-1" style="float: right">
                        <img src="../../assets/photos/Vector2.svg" />
                        <span style="font-size: 12px">
                          {{ formateDate( AllCoverage[index + (index == 0 ? 1 : 2)].coverage_date).date }}
                          {{ formateDate( AllCoverage[index + (index == 0 ? 1 : 2)].coverage_date).day }}</span
                        >
                      </div>
                    </div>
                  </div>
                </div>
              </swiper-slide>
            </swiper>

            <div class="d-flex justify-content-center mt-3 cla">
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
        </div>
      </div>
    </section>
    <Modal @close="toggleModal" :modalActive="modalActive">
      <div style="position: relative">
        <div class="modal-content">
          <iframe
            class="vid"
            width="100%"
            height="400"
            src="https://www.youtube-nocookie.com/embed/rI3FiAtMBNk"
            title="YouTube video player"
            frameborder="0"
            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
            allowfullscreen
          ></iframe>
          <!-- <video class="vid" loop autoplay muted controls ref="video">
          <source src="../../assets/videos/e_e.mp4" type="video/mp4" />
        </video> -->
        </div>
      </div>
    </Modal>
  </div>
</template>
<script>
import { Swiper, SwiperSlide } from "swiper/vue";
import { Autoplay, Pagination, Navigation } from "swiper/modules";

import "swiper/css";
// import "swiper/css/navigation";
import "swiper/css/pagination";
import { ref } from "vue";
import { useSwiper } from "swiper/vue";

import Modal from "../../components/ModalComp.vue";
export default {
  components: { Swiper, SwiperSlide, Modal },

  setup() {
    const modalActive = ref(false);
    const toggleModal = () => {
      modalActive.value = !modalActive.value;
    };
    const swiper = useSwiper();

    return {
      modalActive,
      toggleModal,
      swiper,
      modules: [Pagination, Autoplay, Navigation],
    };
  },
  data() {
    return {
      isPlaying: false,
      isPaused: false,
      AllCoverage: [],
    };
  },
  mounted() {
    this.button = this.$refs.button;
    // this.button.style.display = "block";
  },
  methods: {
    playVideo() {
      this.isPlaying = !this.isPlaying;
      if (this.isPlaying) {
        this.$refs.video.play();
        this.button.style.display = "none";
      } else {
        this.$refs.video.pause();
        this.button.style.display = "block";
      }
    },
    getAchivement() {
      axios
        .get("/coverage/lastCoverage")
        .then((res) => {
          if (res.data.status == true) {
            this.AllCoverage = res.data.lastCoverage;
            console.log( this.AllCoverage)
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
        day: moment(date).format("dddd"),
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
.swiper-horizontal > .swiper-pagination-bullets .swiper-pagination-bullet,
.swiper-pagination-horizontal.swiper-pagination-bullets
  .swiper-pagination-bullet {
  margin: -13px !important;
}
.btnn:hover {
  filter: opacity(100%) !important;
}
.card {
  height: 100%;
  width: 48%;
}
.card-body {
  height: 100% !important;
}
.title {
  color: #306386;
  font-weight: bold;
}
.vid {
  border-radius: 16px;
  width: 100%;
}
.vid:hover {
  cursor: pointer;
}
.back {
  background-image: url("../../assets/photos/back22.svg");
  background-repeat: no-repeat;
  background-size: cover;
}

.center-button {
  background-color: transparent;
  border: none;
  position: absolute;
  right: 40%;
  top: 36%;
  z-index: 99;
}

@media only screen and (max-width: 991px) {
  span {
    font-size: 10px !important;
  }
  .center-button {
    background-color: transparent;
    border: none;
    position: absolute;
    right: 35%;
    top: 25%;
    z-index: 99;
    width: 5% !important;
  }
  .day {
    scale: 70%;
    transform: translateX(40px);
  }
  .shp {
    display: none;
  }
}
</style>
