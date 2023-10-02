<template>
  <section class="Reports pt-3 pb-5">
    <div class="container pt-5">
      <div class="d-flex gap-3 mb-5 pt-5">
        <router-link :to="{ name: 'Home' }"
          ><img src="../../assets/photos/home(2).svg"
        /></router-link>
        <p class="lino">التقارير</p>
      </div>
      <div v-for="report in reports" :key="report.id"
        class="card mb-5 respom"
        style="
          width: 50%;
          background: white;
          box-shadow: 0px 16px 19px rgba(0, 0, 0, 0.12);
          border-radius: 16px;
          overflow: hidden;
          border: none;
          margin: auto;
        "
      >
        <div
          style="margin-left: auto"
          class="d-flex align-items-center pe-3 pt-3 mb-3"
        >
          <img src="../../assets/photos/Vector2.svg" />
          <span> &nbsp; &nbsp; {{ formateDate(report.report_date).date + " " + formateDate(report.report_date).day }}</span>
        </div>
        <!-- <img  src="holder.js/100x180/" alt="Title" /> -->
        <div class="card-body mb-4" style="text-align: justify">
          <h4 class="card-title fw-bold" style="color: #306386">
            {{ report.title }}
          </h4>
          <p class="card-text mb-5" v-html="report.overview"></p>
          <a :href="'./report/downloadPdf/' + report.id"  class="link"
            ><img src="../../assets/photos/logos_google-drive.svg" /> &nbsp; عن
            الاتحاد
          </a>
        </div>
      </div>

      <!-- <router-link
        :to="{ name: 'action' }"
        style="
          line-height: 50px;
          text-align: left;
          padding-left: 30px;
          color: #d2398d;
        "
      >
        <p class="fw-bold">المزيد ..</p></router-link
      > -->
    </div>
    <VPagination
        v-model="page"
        :pages="data.last_page"
        :range-size="1"
        active-color="#DCEDFF"
        align="center"
        @update:modelValue="getReports"
      ></VPagination>
  </section>
</template>
<style>
.lino {
  color: #d63384;
  border: 2px solid #d63384;
  border-radius: 26px;
  padding: 4px 20px;
}
.link {
  padding: 6px 30px 6px 30px;

  border-radius: 30px;
  color: #d2398d;
  cursor: pointer;
  border: 2px solid #d2398d;
}
a {
  cursor: pointer;
}
.link:hover {
  color: white;
  background: #d2398d;
}
.Reports {
  background: url("../../assets/photos/image_16.jpg");
  background-repeat: no-repeat;
  background-size: cover;
  background-attachment: fixed;
}
.man {
  padding-top: 100px;
}

@media only screen and (max-width: 991px) {
  .respom {
    width: 100% !important;
  }
}
</style>
<script>
export default {
  data() {
    return {  
      page: 1,
      reports : [],
      data : {},
    }
  },
  methods : {
 
    getReports(page = this.page) {
      axios
        .get("/report/activeReports?page=" + page)
        .then((res) => {
          if (res.data.status == true) {
            this.reports = res.data.reports.data;
            this.data = res.data.reports;
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
        year: moment(date).format("YYYY"),
        date: moment(date).format("L"),
        time: moment(date).format(" h:mm:ss a"),
      };
    },
  },
  created() {
    this.getReports()
  }
};
</script>