<template>
  <div class="container mt-5 mb-5">
    <div class="row align-items-center justify-content-center">
      <div
      v-if="achivementRobots[0]"
        class="col-md-12 col-lg-6 maincard p-5"
        style="
          background: linear-gradient(180deg, #022c48 0%, #306386 100%);
          border-radius: 16px;
          overflow: hidden;
          height: 375px;
        "
      >
        <div class="text-white" style="text-align: justify">
          <img class="mt-3 mb-4" :src="'./images/achivement/icons/' + achivementRobots[0].achivement_icon" />
          <h5 class="fw-bold mb-3">{{achivementRobots[0].title}}</h5>
          <p style="font-size: 18px" v-html="achivementRobots[0].content">
         
          </p>
        </div>
      </div>
      <div class="col-md-12 col-lg-6">
        <div class="d-flex flex-column gap-3">
          <div class="row justify-content-center m-1 gap-3">
            <div class="col sty" v-if="achivementRobots[1]">
              <img :src="'./images/achivement/icons/' + achivementRobots[1].achivement_icon" />
              <h6 class="mt-3" style="color: #306386">
                {{achivementRobots[1].title}}
              </h6>
              <p style="color: #d2398d">المزيد ...</p>
            </div>

            <div class="col sty" v-if="achivementRobots[2]"
>
              <img :src="'./images/achivement/icons/' + achivementRobots[2].achivement_icon" />
              <h6 class="mt-3" style="color: #306386"> {{achivementRobots[2].title}}</h6>
              <p style="color: #d2398d">المزيد ...</p>
            </div>
          </div>
          <div
          v-if="achivementRobots[3]"
            style="
              width: 100%;
              height: 100%;
              position: relative;
              background: #e2f4fe;
              border-radius: 16px;
              overflow: hidden;
            "
          >
            <img
              class="mt-3 mb-4 me-4"
              style="float: right"
              :src="'./images/achivement/icons/' + achivementRobots[3].achivement_icon"
            />
            <div class="mt-5">
              <h5 style="color: #306386">{{ achivementRobots[3].title }}</h5>
              <p style="color: #d2398d">المزيد..</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<style scoped>
.sty {
  width: 100%;
  height: 200px;
  background: #e2f4fe;
  border-radius: 16px;
  overflow: hidden;
}

.st {
  text-align: right !important;
  padding-bottom: 140px;
}
@media only screen and (max-width: 991px) {
  .st {
    padding-bottom: 0px;
  }
  .sty {
    padding-top: 14px;
    padding-bottom: 0px;
    padding-left: 0px;
    padding-right: 0px;
    background: #e2f4fe;
    border-radius: 16px;
    overflow: hidden;
  }
  .sty p {
    margin-top: 20px;
    font-size: 15px;
  }
  .sty h5 {
    font-size: 10px;
  }
  .maincard {
    background: linear-gradient(180deg, #022c48 0%, #306386 100%);
    border-radius: 0px !important;
    overflow: hidden;
    height: 375px;
  }
}
</style>
<script>
export default {
  data() {
    return {
      achivementRobots:[],
    }
  },
  methods : {
    getAchivement() {
  axios
    .get("/achivement/achivementTypes")
    .then((res) => {
      if (res.data.status == true) {
        this.achivementRobots = res.data.achivement.achivementRobots;
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
    this.getAchivement()
  }
};
</script>