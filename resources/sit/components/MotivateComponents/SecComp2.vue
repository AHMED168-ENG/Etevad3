<template>
  <section class="pt-5">
    <div class="d-flex gap-3 mb-4 mt-3 pt-5 container">
      <img src="../../assets/photos/home(2).svg" />
      <p class="lino mt-3">&nbsp; الأخبار</p>
    </div>
    <div class="container" style="position: relative">
      <img style="width:100% !important;object-fit: cover;border-radius: 25px;aspect-ratio: 1/0.5;" :src="'./images/news/' + news.image"  />
    </div>
    <div
      style="
        margin-top: -300px;
        padding-top: 329px;
        padding-bottom: 276px;
        height: 100%;
        background: linear-gradient(180deg, #022c48 0%, #306386 100%);
      "
    >
      <div class="container res">
        <h3
          style="
            margin-bottom: 23px;
            text-align: justify;
            color: white;
            font-size: 32px;
            font-weight: bold;
            word-wrap: break-word;
          "
        >
          {{ news.title }}
        </h3>
        <div
          style="margin-left: auto; color: #306386"
          class="d-flex align-items-center pe-3 pt-3 mb-3"
        >
          <img src="../../assets/photos/Vector2.svg" />
          <span> &nbsp; &nbsp; {{ formateDate(news.news_date).date + " " + formateDate(news.news_date).day }}</span>
        </div>
        <div
          style="
            width: 100%;
            margin-bottom: 20px;
            transform: rotate(180deg);
            border: 1px #2172a9 solid;
          "
        ></div>

        <p
          style="
            text-align: justify;
            color: #b2e3ff;
            font-size: 20px;
            font-weight: 400;
            line-height: 32px;
            word-wrap: break-word;
          "
        v-html="news.full_description">
        </p>
      </div>
    </div>
  </section>
</template>

<script>

export default {
  data() {
    return {
      news : {}
    }
  },
  methods:{
    formateDate(date) {
      return {
        day: moment(date).format("dddd"),
        date: moment(date).format("L"),
        time: moment(date).format(" h:mm:ss a"),
      };
    },
    getNews() {
      axios
        .get("/news/show/" + this.$route.params.id)
        .then((result) => {
          if (result.data.status == true) {
            this.news = result.data.news
          } else if (result.data.status == null) {
            Toast.fire({
              icon: "error",
              title: result.data.error,
            });
          } else {
            this.message.errors = result.data.errors;
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
  }
};
</script>


<style scoped>
.lino {
  color: #d63384;
  border: 2px solid #d63384;
  border-radius: 26px;
  padding: 4px 20px;
}
.res {
  width: 72%;
}
@media only screen and (max-width: 991px) {
  .res {
    width: 100%;
  }
}
</style>
