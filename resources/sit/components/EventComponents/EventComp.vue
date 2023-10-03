<template>
  <div>
    <section class="main" style="margin-bottom: 200px">
        <div
          class="card border-0 mb-5 pt-5"
          style="background: #e2f4fe; border-radius: 16px; overflow: hidden"
        >
          <img class="card-img-top" :src="event.image ? './images/event/' + event.image : ''" alt="Title" />
        </div>
        <div class="container">
          <div
            class="card border-0"
            style="
              position: relative;
              background: #e2f4fe;
              border-radius: 16px;
              overflow: hidden;
              margin-top: -130px;
            "
          >
            <div class="card-body" style="background:#E2F4FE">
              <div class="mb-4 me-1 mt-3" style="text-align: right">
                <p class="lino">&nbsp; الفاعليات</p>
              </div>
              <div class="row align-items-center justify-content-between ps-4 pe-4">
                <div class="col-12 col-md-12 col-lg-10" style="position: relative">
                  <div>
                    <h4
                      class="card-title mb-4"
                      style="
                        color: #306386;

                        font-weight: bold;
                        line-height: 40px;
                        text-align: right;
                      "
                    >
                      {{ event.name }}
                    </h4>
                    <p style="text-align: right" v-html="event.overview">
                    </p>
                  </div>

                  <div>
                    <img
                      src="../../assets/photos/Group_15.svg"
                      style="
                        position: absolute;
                        right: -20px;
                        top: 40px;
                        width: 80px;
                      "
                      class="respons"
                    />
                  </div>
                </div>

                <div class="col-12 col-md-12 col-lg-1">
                  <div style="width: 50px">
                    <div
                      style="
                        border-radius: 16px;
                        overflow: hidden;
                        border: 0.8px #d2398d solid;
                        flex-direction: column;
                        justify-content: end !important;
                        align-items: center;

                        display: inline-flex;
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
                          width: 80px;
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
                      <br>
                      {{ formateDate(event.event_date).year }}
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="mt-4 mb-5" style="text-align: right">
            <h4
              class="card-title mb-4"
              style="
                color: #306386;

                font-weight: bold;
                line-height: 40px;
                text-align: right;
              "
            >
              تفاصيل إضافية
            </h4>
            <p v-html="event.full_description">
            </p>
          </div>
          <div
            style="
              width: 100%;
              height: 100%;
              transform: rotate(180deg);

              border: 1px #d7dadd solid;
            "
          ></div>
          <h5
            class="mb-4"
            style="
              color: #306386;
              text-align: center !important;
              font-weight: bold;
              line-height: 40px;
            "
          >
            يرجى تعبئة النموذج للتسجيل في البرنامج
          </h5>
          <div class="mb-4 me-1 mt-3">
            <a
              @click="toggleModal"
              class="link"
              style="background-color: #d2398d; font-weight: bold; color: white"
            >
              &nbsp; سجل
            </a>
          </div>
        </div>
    </section>
    <Modal @close="toggleModal" :modalActive="modalActive">
      <div style="position: absolute; top: -70px; left: 160px; z-index: 999">
        <img
          class="icon rspon"
          src="../../assets/photos/send.png"
          style="width: 50%"
        />
      </div>

      <div style="position: relative">
        <div class="modal-content">
          <h4 class="fw-bold pt-5 mb-5 text-center">
            يرجى تعبئة النموذج للتسجيل في البرنامج
          </h4>
          <form class="pe-md-5 pe-2 ps-2 ps-md-5 pb-5">
            <input
              type="text"
              :class="[
                'form-control mb-3',
                eventRecord.errors.name ? 'is-invalid' : '',
              ]"
              v-model="eventRecord.name"
              placeholder="الاسم ثلاثي"
            />
            <span
                  v-if="eventRecord.errors.name"
                  class="invalid-feedback"
                >
              {{ eventRecord.errors.name[0] }}
            </span>
            <div class="row">
              <div class="col-4">
                <input
                  type="number"
                  :class="[
                    'form-control mb-3',
                    eventRecord.errors.age ? 'is-invalid' : '',
                  ]"
                  v-model="eventRecord.age"
                  placeholder="العمر"
                />
                <span
                  v-if="eventRecord.errors.age"
                  class="invalid-feedback"
                >
              {{ eventRecord.errors.age[0] }}
            </span>
              </div>
              <div class="col-8">
                <input
                  type="text"
                  :class="[
                    'form-control mb-3',
                    eventRecord.errors.mobile ? 'is-invalid' : '',
                  ]"
                  placeholder="رقم الهاتف"
                  v-model="eventRecord.mobile"
                />
                <span
                    v-if="eventRecord.errors.mobile"
                    class="invalid-feedback"
                  >
                {{ eventRecord.errors.mobile[0] }}
              </span>
              </div>
            </div>
            <input
              type="Email"
              :class="[
                    'form-control mb-3',
                    eventRecord.errors.email ? 'is-invalid' : '',
                  ]"
                  placeholder="الايميل الخاص بك"
                  v-model="eventRecord.email"
                />
                <span
                    v-if="eventRecord.errors.email"
                    class="invalid-feedback"
                  >
                {{ eventRecord.errors.email[0] }}
              </span>
            <input
              type="submit"
              name="submit"
              value="ارسال"
              @click.prevent="saveRecord"
              style="
                background-color: #d2398d;
                border: none;
                color: white;
                border-radius: 16px;
                padding: 5px 25px 5px 25px;
              "
            />
          </form>
        </div>
      </div>
    </Modal>
  </div>
</template>
<style scoped>
.link {
  padding: 5px 35px 5px 35px;

  border-radius: 30px;
  color: #d2398d;
  cursor: pointer;
}
a {
  cursor: pointer;
}
.link:hover {
  border: 2px solid #d2398d;
}
</style>

<script>
import Modal from "../../components/ModalComp.vue";
import { ref } from "vue";
export default {
  components: {
    Modal,
  },
  setup() {
    const modalActive = ref(false);
    const toggleModal = () => {
      modalActive.value = !modalActive.value;
    };
    return {
      modalActive,
      toggleModal,
    };
  },
  data() {
    return {
      eventRecord:{
        name:"",
        email:"",
        age:null,
        mobile:null,
        event_id:this.$route.params.id,
        errors:[]
      },
      event:{}
    }
  },
  methods:{
    formateDate(date) {
      return {
        day: moment(date).format("dddd"),
        year: moment(date).format("YYYY"),
        date: moment(date).format("L"),
        time: moment(date).format(" h:mm:ss a"),
      };
    },
    getEvents() {
      axios
        .get("/event/show/" + this.$route.params.id)
        .then((result) => {
          if (result.data.status == true) {
            this.event = result.data.event
            console.log(this.event)
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
    saveRecord() {
      axios
        .post("/event-recordings/store", this.eventRecord, {
          headers: { "Content-Type": "multipart/form-data" },
        })
        .then((result) => {
          if (result.data.status == true) {
            this.eventRecord.errors = {};
            this.eventRecord = {
              name:"",
              email:"",
              age:null,
              phone:null,
              errors:[]
            }
            alert("تم التسجيل في الحدث بنجاح")
          } else if (result.data.status == null) {
            Toast.fire({
              icon: "error",
              title: result.data.error,
            });
          } else {
            this.eventRecord.errors = result.data.errors;
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
    this.getEvents()
  }
};
</script>
<style scoped>
.lino {
  color: #d63384;
  border: 2px solid #d63384;
  border-radius: 26px;
  padding: 4px 20px;
  width: 10%;
}
.modal-content {
  align-items: center;
  position: relative;
  background: linear-gradient(180deg, #65bdfa 0%, #306386 100%);
  box-shadow: 0px 4px 30px #3ba3da;
  padding-top: 100px;
  border-radius: 16px;
  overflow: hidden;
  color: white;
  width: 100%;
  height: 100%;
}
.card-title {
  width: 20%;
}
@media only screen and (max-width: 991px) {
  .rspon {
    display: none;
  }
  .icon {
    width: 100% !important;
    margin-right: 100px;
  }
  p {
    text-align: center;
  }
  .lino {
    color: #d63384;
    border: 2px solid #d63384;
    border-radius: 26px;
    padding: 4px 20px;
    width: 40%;
  }
  .card-title {
    width: 100%;
    text-align: center !important;
  }
  .respons {
    display: none !important;
  }
}
</style>
