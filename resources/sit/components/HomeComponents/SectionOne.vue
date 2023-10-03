

<template>
  <section class="OneSection pt-5">
    <div class="container">
      <div>
        <p
          class="new_button2"
          style="
            padding-left: 40px;
            padding-right: 40px;
            padding-top: 2px;
            padding-bottom: 4px;
            border: 2px solid #d2398d;
            border-radius: 24px;

            color: #d2398d;
            font-weight: bold;
            float: center;
            margin-bottom: 50px;
          "
        >
          تابع أخبارنا
        </p>
      </div>
      <div class="row" v-if="news[0]">
        <div class="col-12 col-md-6">
          <img
            :src="'./images/news/' + news[0].image"
            style="border-radius: 25px; width: 100%"
          />
        </div>
        <div class="col-12 col-md-5 text-white">
          <router-link
            :to="{ name: 'motivatcover', params: { ico: 'news' } }"
            class="new_button1"
            style="
              padding-left: 40px;
              padding-right: 40px;
              padding-top: 2px;
              padding-bottom: 4px;
              border: 2px solid #d2398d;
              border-radius: 24px;
              text-decoration: none;
              color: #d2398d;
              font-weight: bold;
              float: right;
              margin-bottom: 50px;
            "
            >تابع أخبارنا</router-link
          >
          <div class="">
            <h5
              class="pargraph"
              style="
                font-weight: bold;

                text-align: justify;
                line-height: 40px;
              "
            >
              {{ news[0].title }}
            </h5>
            <p style="text-align: justify; font-size: 17px ; margin: 0 !important;  overflow: hidden;display: -webkit-box;-webkit-line-clamp: 2;-webkit-box-orient: vertical;" v-html="news[0].full_description"></p>
          </div>
          <div class="d-flex justify-content-between text-white">
            <div>
              <img src="../../assets/photos/Vector2.svg" style="width: 20%" />
              <span style="font-size: 9px"> {{ formateDate(news[0].news_date).date + " " + formateDate(news[0].news_date).day }} </span>
            </div>
            <div>
              <router-link
                :to="'/news/' + news[0].id"
                style="line-height: 50px; padding-left: 30px; color: #d2398d"
              >
                <p class="fw-bold">المزيد ..</p></router-link
              >
            </div>
          </div>
        </div>
      </div>
      <div class="row gap-4 justify-content-center">
        <div
          v-for="element in news.slice(1)"
          :key="element"
          class="card col-12 col-md-4 respon"
          style="background: #306386; color: white"
        >
          <img
            class=""
            :src="'./images/news/' + element.image"
            alt="Card image cap"
          />
          <div class="card-body">          
            <router-link style="text-decoration: none;" :to="'/news/' + element.id">
              <p style="text-align: right; font-size: 17px ; margin: 0 !important;color:white;" class="card-text fw-bold" >{{ element.title }}</p>
            </router-link>

            <div style="float: right;width:32%" >
              <img src="../../assets/photos/Vector2.svg" style="width: 23%" />
              <span style="font-size: 9px"> {{ formateDate(news[0].news_date).date + " " + formateDate(news[0].news_date).day }} </span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>
<script>
export default {
  data() {
    return {
      news : []
    };
    
  },
  methods : {
    formateDate(date) {
      return {
        day: moment(date).format("dddd"),
        date: moment(date).format("L"),
        time: moment(date).format(" h:mm:ss a"),
      };
    },
    getNews() {
      axios
        .get("/news/lastNews")
        .then((res) => {
          if (res.data.status == true) {
            this.news = res.data.news;
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
  }
};
</script>
<style scoped>
.card {
  background-color: transparent !important;
}
.card img {
  border-radius: 5%;
}
.OneSection {
  background: linear-gradient(180deg, #022c48 0%, #306386 100%);
}

.new_button2 {
  display: none;
}
.new_button1 {
  display: block;
}
.respon {
  width: 30% !important;
  margin-bottom: 50px;
}
.row .respon {
  padding-left: 0px !important;
  padding-right: 0px !important;
}
.pargraph {
  width: 40%;
}
@media only screen and (max-width: 991px) {
  .new_button2 {
    display: block;
    float: center !important;
  }
  .new_button1 {
    display: none;
  }
  .respon {
    width: 90% !important;
    box-shadow: none !important;
  }
  .pargraph {
    width: 100%;
  }
}
</style> 




