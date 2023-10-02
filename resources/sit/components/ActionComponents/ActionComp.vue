<template>
  <section class="container pt-5" style="margin-bottom: 200px">
    <div class="d-flex gap-3 mb-4 mt-3 pt-5">
      <router-link :to="{ name: 'Home' }"
        ><img src="../../assets/photos/home(2).svg"
      /></router-link>
      <p class="lino">&nbsp;الفعاليات</p>
    </div>
    <div v-for="event in events"
    :key="event.id"
      class="card border-0 mb-5"
      style="background: #e2f4fe; border-radius: 16px; overflow: hidden"
    >
      <img
        class="card-img-top"
        :src="'./images/event/' + event.image"
        alt="Title"
      />
      <div class="card-body">
        <div class="d-flex gap-3 gap-md-5 align-items-center">
          <div class="">
            <div style="width: 90px">
              <div
                class="sect"
                style="
                  padding: 5px;
                  border-radius: 16px;
                  overflow: hidden;
                  border: 0.8px #d2398d solid;
                  flex-direction: column;
                  justify-content: center;
                  align-items: center;
                  gap: 1px;
                  display: inline-flex;
                  width: 80% !important;
                "
              >
                <p
                  style="
                    text-align: right;
                    color: #d2398d;
                    font-size: 24px;
                    font-family: Cairo;
                    font-weight: 700;
                    word-wrap: break-word;
                  "
                >
                  {{ new Date(event.event_date).getDate() }}
                </p>
                <div
                  style="
                    width: 50px;
                    height: 0px;
                    transform-origin: 0 0;
                    border: 1px #889199 solid;
                  "
                ></div>
                <div
                  style="
                    text-align: center;
                    color: #306386;
                    font-size: 15px;
                    font-family: Cairo;
                    font-weight: 400;
                    line-height: 28px;
                    word-wrap: break-word;
                  "
                >
                {{ formateDate(event.event_date).day }}
                {{ formateDate(event.event_date).year }}
                 
                </div>
              </div>
            </div>
          </div>
          <div style="position: relative">
            <h4
              class="titlee card-title"
              style="
                color: #306386;

                font-weight: bold;
                line-height: 40px;
              "
            >
              {{ event.name }}
            </h4>
            <img
              class="sshap"
              src="../../assets/photos/Group_15.svg"
              style="position: absolute; right: -20px; top: 37px; width: 80px"
            />
          </div>
        </div>
      </div>
      <router-link
        style="
          margin-top: -40px;
          text-align: left;
          padding-left: 30px;
          color: #d2398d;
        "
        :to="{ name: 'event' }"
        ><p class="fw-bold">تفاصيل ..</p></router-link
      >
    </div>

    <VPagination
    v-model="page"
    :pages="data.last_page"
    :range-size="1"
    active-color="#DCEDFF"
    @update:modelValue="getEvents"
  ></VPagination>
  </section>
</template>
<style scoped>
.lino {
  color: #d63384;
  border: 2px solid #d63384;
  border-radius: 26px;
  padding: 4px 20px;
}
.titlee {
  width: 50%;
}

@media only screen and (max-width: 991px) {
  .titlee {
    width: 100%;
    font-size: 15px;
    line-height: 25px !important;
    text-align: right;
  }
  .sshap {
    display: none;
  }
  .card-img-top {
    height: 150px;
  }
}
</style>
<script>
export default {
  data() {
    return {  
      page: 1,
      events : [],
      data : {},
    }
  },
  methods : {
    getEvents(page = this.page) {
      axios
        .get("/event/activeEvent?page=" + page)
        .then((res) => {
          if (res.data.status == true) {
            this.events = res.data.event.data;
            this.data = res.data.event;
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
    this.getEvents()
  }
};
</script>