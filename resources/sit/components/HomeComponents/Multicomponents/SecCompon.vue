<template>
  <div class="container mt-5 mb-5">
    <div class="row">
      <div 
      v-if="achivementWireless[0]"
        class="maincard col-12 col-md-12 col-lg-6 mb-3 p-5"
        style="
          background: linear-gradient(180deg, #022c48 0%, #306386 100%);
          border-radius: 16px;
          height: 305px;
          overflow: hidden;
        "
      >
        <div class="text-white" style="text-align: right">
          <img class="" :src="'./images/achivement/icons/' + achivementWireless[0].achivement_icon" />
          <h5 class="mb-4 fw-bold mt-4">{{ achivementWireless[0].title  }}</h5>
          <p style="font-size: 18px" v-html="achivementWireless[0].content"></p>
        </div>
      </div>
      <div class="col-12 col-md-12 col-lg-6 mt-1">
        <div class="row gap-3">
          <div class="col-12 row justify-content-between">
            <router-link class="col-6" :to="{ name: 'action' }"       v-if="achivementWireless[1]">
              <div class="carrd">
                <img :src="'./images/achivement/icons/' + achivementWireless[1].achivement_icon" />
                <h6 class="mt-3" style="color: #306386">{{ achivementWireless[1].title  }}</h6>
                <p style="color: #d2398d">المزيد ...</p>
              </div>
            </router-link>
            <router-link class="col-6" :to="{ name: 'action' }"       v-if="achivementWireless[2]">
              <div class="carrd">
                <img :src="'./images/achivement/icons/' + achivementWireless[2].achivement_icon" />
                <h6 class="mt-3" style="color: #306386"> {{ achivementWireless[2].title  }}</h6>
                <p style="color: #d2398d">المزيد ...</p>
              </div>
            </router-link>
          </div>
          <div
            v-if="achivementWireless[3]"
            class="col-12 me-2"
            style="background-color: #e2f4fe; border-radius: 16px; width: 93%"
          >
            <img
              class="mt-4 mb-4 me-2"
              style="float: right"
              :src="'./images/achivement/icons/' + achivementWireless[3].achivement_icon"
            />
            <div class="mt-5">
              <h5 style="color: #306386">{{ achivementWireless[3].title  }}</h5>
              <p style="color: #d2398d">المزيد ...</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<style scoped>
.carrd {
  width: 100%;
  height: 160px;
  background: #e2f4fe;
  border-radius: 16px;
  overflow: hidden;
}
a {
  text-decoration: none !important;
}

@media only screen and (max-width: 991px) {
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
      achivementWireless:[],
    }
  },
  methods : {
    getAchivement() {
  axios
    .get("/achivement/achivementTypes")
    .then((res) => {
      if (res.data.status == true) {
        this.achivementWireless = res.data.achivement.achivementWireless;
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

