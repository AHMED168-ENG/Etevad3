<template>
  <section class="container">
    <div class="mt-5 mb-3 viid" style="position: relative">
      <iframe
        class="vid"
        width="100%"
        height="100%"
        :src="'https://www.youtube.com/embed/' + coverages[0]?.video_id"
        title="YouTube video player"
        frameborder="0"
        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
        allowfullscreen
      ></iframe>

      <!-- <video class="myVideo mt-5 mb-4" controls loop muted style="height: 100%">
        <source src=" " type="video/mp4" />
        <button
          v-if="!isPlaying || !isPaused"
          @click="toggleModal"
          ref="button"
          class="center-button"
        >
          <img src="../../assets/photos/play-button.svg" />
        </button>
        <button class="center-button" v-if="isPlaying" @click="playVideo">
          <img src="../../assets/photos/puse.png" />
        </button>
      </video> -->
    </div>
    <div class="row">
      <div v-for="coverage in coverages.slice(1)" :key="coverage.id" class="col-12 col-md-6 pb-5">
        <div
          class="card mb-2"
          style="
            background: #ffffff;
            box-shadow: 0px 4px 4px rgba(162.56, 162.56, 162.56, 0.25);
            border-radius: 16px !important;
          "
        >
          <div class="bn">
            <iframe
              class="vid"
              width="100%"
              height="100%"
              :src="'https://www.youtube.com/embed/' + coverages[0]?.video_id"
              title="YouTube video player"
              frameborder="0"
              allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
              allowfullscreen
            ></iframe>
          </div>
          <div class="card-body">
            <p
              class="card-text fw-bold"
              style="text-align: right; font-size: 12px; color: #306386"
            >
             {{ coverage.title }}
            </p>

            <div style="float: right">
              <img src="../../assets/photos/Vector2.svg" />
              <span style="font-size: 15px"> {{ formateDate(coverage.coverage_date).date + " " + formateDate(coverage.coverage_date).day }} </span>
            </div>
          </div>
        </div>
      </div>
    </div>
    <VPagination
    v-model="page"
    :pages="data.last_page"
    :range-size="1"
    active-color="#DCEDFF"
    @update:modelValue="getCoverages"
  ></VPagination>
  </section>
</template>
<style>
.viid {
  height: 600px;
}
.card {
  width: 100%;
}
.myVideo {
  position: relative;
  top: 0;
  left: 0;
  width: 100%;
  border-radius: 25px;
  object-fit: cover;
  background-color: rgba(0, 0, 0, 0.447);
}
.overlay1 {
  height: 100%;
  top: 0;
  left: 0;
  position: absolute;
  display: flex;
  justify-content: center;
  align-items: center;
  flex-direction: column;
  background-color: red;
  opacity: 1;
}
.vid {
  border-radius: 16px;
  width: 100%;
}
.bn {
  height: 300px;
}
@media only screen and (max-width: 991px) {
  .viid {
    height: 200px;
  }
  .bn {
    height: 100%;
  }
}
</style>
<script>
export default {
  data() {
    return {  
      page: 1,
      coverages : [],
      data:{}
    }
  },
  methods : {
    getCoverages(page = this.page) {
      axios
        .get("/coverage/activeCoverages?page=" + page)
        .then((res) => {
          if (res.data.status == true) {
            this.coverages = res.data.coverage.data;
            this.data = res.data.coverage;
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
    this.getCoverages()
  }
};
</script>
