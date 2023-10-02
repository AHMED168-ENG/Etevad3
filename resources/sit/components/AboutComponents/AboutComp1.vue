<template>
  <div class="subCopm" style="margin-bottom: 200px">
    <div class="d-flex gap-5 mt-5 mb-5" style="width: 85%; margin: auto">
      <div class="shape"><img src="../../assets/photos/Chat.svg" /></div>
      <div>
        <h4 style="text-align: justify; font-weight: bold; color: #306386">
          عن الإتحاد
        </h4>
        <p style="text-align: justify" v-html="about.description">
          
        </p>
      </div>
    </div>
    <div class="row gap-1 justify-content-around align-items-center">
      <div class="cardd col-5 col-sm-12 col-md-6">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <div>
            <h5 style="text-align: justify; font-weight: bold; color: #306386">
              الرؤية
            </h5>
          </div>
          <div><img src="../../assets/photos/Eyes.svg" /></div>
        </div>
        <p style="text-align: justify" v-html="about.vision">
          
        </p>
      </div>
      <div class="col-5 col-sm-12 col-md-6 cardd">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <div>
            <h5 style="text-align: justify; font-weight: bold; color: #306386">
              الرسالة
            </h5>
          </div>
          <div><img src="../../assets/photos/Massage.svg" /></div>
        </div>
        <p style="text-align: justify" class="" v-html="about.message"></p>
          
      </div>
    </div>

    <div
      class="row justify-content-right align-items-center why mt-2 mt-md-4 p-1 p-md-5"
      style="
        background: linear-gradient(180deg, #022c48 0%, #306386 100%);
        border-radius: 16px;
        margin-bottom: 15px;
        overflow: hidden;
      "
    >
      <div
        class="col-7 col-md-3 pt-md-4 d-flex flex-column gap-3 "
        style="margin-left: auto"
      >
        <img
          src="../../assets/photos/about_1.svg"
          width="40%"
          class="pt-4 pt-md-1"
        />
        <h3 class="text-white fw-bold titt">الركائز الإستراتيجية</h3>
        <img class="shape" src="../../assets/photos/aboutVector.svg" />
      </div>
      <div class="col-12 col-md-8 row gap-4 me-md-1 me-lg-5">
        <div class="col-12 text-white">
          <h5 style="font-weight: bold; text-align: justify" v-html="about.strategic_one_title"></h5>
          <p style="text-align: justify" v-html="about.strategic_one_content">
            
          </p>
        </div>
        <div class="col-12 text-white">
          <h5 style="font-weight: bold; text-align: justify" v-html="about.strategic_tow_title"></h5>
          <p style="text-align: justify" v-html="about.strategic_tow_content">
          </p>
        </div>
        <div class="col-12 text-white">
          <h5 style="font-weight: bold; text-align: justify" v-html="about.strategic_three_title"></h5>
          <p style="text-align: justify" v-html="about.strategic_three_content">
            
          </p>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      about : [],
    }
  },
  methods : {
    getAboutPage() {
      axios
        .get("/about-us/index")
        .then((res) => {
          if (res.data.status == true) {
            this.about = res.data.about_us;
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
    this.getAboutPage()
  }
};
</script>


<style scoped>
.cardd {
  background: #e2f4fe;
  border-radius: 16px;
  overflow: hidden;
  width: 48% !important;
  height: 190px;
  padding: 20px;
}

.titt {
  text-align: justify;
  width: 50%;
  line-height: 40px;
}

@media only screen and (max-width: 991px) {
  .titt {
    text-align: justify;
    width: 100%;
    font-size: 20px;
  }
  .shape {
    display: none;
  }
  .card {
    background: none !important;
    border-radius: 16px;
    overflow: hidden;
    width: 95% !important;
    gap: 50px;
    margin-bottom: 10px;
    height: 100%;
    padding: 20px;
  }
}
</style>
