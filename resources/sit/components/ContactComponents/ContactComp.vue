<template>
  <section class="container pt-5" style="margin-bottom: 200px">
    <div class="d-flex gap-3 mb-4 mt-3 pt-5">
      <router-link :to="{ name: 'Home' }">
        <img class="mt-3" src="../../assets/photos/home(2).svg" />
      </router-link>
      <p class="lino mt-3">اتصل بنا</p>
    </div>

    <div class="row">
      <div class="col-12 col-md-12 col-lg-6">
        <div class="">
          <div>
            <h3
              style="
                text-align: right;
                color: #306386;
                font-size: 32px;
                width: 40%;
                font-weight: 700;
                word-wrap: break-word;
              "
              class="subject"
            >
              لديك استفسارات أو اقتراحات
            </h3>
            <p
              class="prag"
              style="
                width: 100%;
                text-align: right;
                color: #6a6a6a;
                font-size: 24px;
                width: 60%;
                font-weight: 400;
                line-height: 40px;
                word-wrap: break-word;
              "
            >
              نسعد دائما بتواصلكم معنا من خلال البريد الالكتروني وأرقام التواصل
              الموضحة بالأسفل.
            </p>
          </div>
          <div class=" ">
            <div class="form" style="text-align: right">
              <form>
                <input
                  type="text"
                  :class="[
                        'form-control mb-3',
                        message.errors.name ? 'is-invalid' : '',
                      ]"
                  placeholder="الاسم ثلاثي"
                  v-model="message.name"
                />
                <span
                      v-if="message.errors.name"
                      class="invalid-feedback"
                    >
                  {{ message.errors.name[0] }}
                </span>
                <input
                  type="email"
                  :class="[
                        'form-control mb-3',
                        message.errors.email ? 'is-invalid' : '',
                      ]"
                  placeholder="الاسم ثلاثي"
                  v-model="message.email"
                />
                <span
                      v-if="message.errors.email"
                      class="invalid-feedback"
                    >
                  {{ message.errors.email[0] }}
                </span>
                <div class="row">
                  <div class="col-4">
                    <input
                      type="number"
                      :class="[
                        'form-control mb-3',
                        message.errors.age ? 'is-invalid' : '',
                      ]"
                      placeholder="العمر"
                      v-model="message.age"
                    />
                    <span
                      v-if="message.errors.age"
                      class="invalid-feedback"
                    >
                  {{ message.errors.age[0] }}
                </span>
                  </div>
                  <div class="col-8">
                    <input
                      type="text"
                      :class="[
                        'form-control mb-3',
                        message.errors.phone ? 'is-invalid' : '',
                      ]"
                      placeholder="رقم الهاتف"
                      v-model="message.phone"
                    />
                    <span
                      v-if="message.errors.phone"
                      class="invalid-feedback"
                    >
                  {{ message.errors.phone[0] }}
                </span>
                  </div>
                </div>
                <div class="mb-3">
                  <input
                    type="text"
                    :class="[
                        'form-control mb-3',
                        message.errors.title ? 'is-invalid' : '',
                      ]"
                    placeholder="عنوان الرسالة"
                    v-model="message.title"
                  />
                  <span
                      v-if="message.errors.title"
                      class="invalid-feedback"
                    >
                  {{ message.errors.title[0] }}
                </span>
                </div>
                <div class="mb-3">
                  <textarea
                  :class="[
                        'form-control mb-3',
                        message.errors.message ? 'is-invalid' : '',
                      ]"
                    name="Massage"
                    rows="12"
                    placeholder="نص الرسالة..."
                    v-model="message.message"
                  ></textarea>
                  <span
                      v-if="message.errors.message"
                      class="invalid-feedback"
                    >
                  {{ message.errors.message[0] }}
                </span>
                </div>
                <input
                  type="submit"
                  name="submit"
                  value="ارسال"
                  @click.prevent="saveMessage"
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
        </div>
      </div>

      <div class="col-12 col-md-12 col-lg-6">
        <img src="../../assets/photos/footerimg.svg" width="75%" />

        <div>
          <div
            class="col-md-6 col-lg-6 col-xl-6 mx-auto mt-3"
            style="text-align: right"
          >
            <a> <img class="mb-4" src="../../assets/photos/image_14.svg" /></a>

            <div>
              <div class="mb-4">
                <p class="title">
                  <span><img src="../../assets/photos/Location.svg" /></span>
                  العنوان
                </p>
                <p class="para">
                  الرياض - تقاطع شارع الملك فهد مع شارع الإمام سعود حي النخيل
                  شارع وادي الحدلي مبنى 2
                </p>
              </div>

              <div>
                <p class="title">
                  <span><img src="../../assets/photos/Call.svg" /></span> الهاتف
                </p>
                <p class="para">
                  <a
                    href="tel:+966116027234"
                    style="color: black; text-decoration: none"
                    >+966 11 6027234</a
                  >
                </p>
              </div>

              <div>
                <p class="title">
                  <span><img src="../../assets/photos/Message.png" /></span>
                  البريد الإلكتروني
                </p>
                <p class="para text-black">
                  <a
                    href="mailto:info@tahakoom.gov.sa"
                    style="text-decoration: none; color: black"
                    >info@tahakoom.gov.sa</a
                  >
                </p>
              </div>
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
      message:{
        name:"",
        email:"",
        email : "",
        age:null,
        phone:null,
        title:"",
        message:"",
        errors:[]
      }
    }
  },
  methods:{
    saveMessage() {
      axios
        .post("/contact/store", this.message, {
          headers: { "Content-Type": "multipart/form-data" },
        })
        .then((result) => {
          if (result.data.status == true) {
            // Toast.fire({
            //   icon: "success",
            //   title: "تم ارسال الرساله بنجاح",
            // });
            alert("تم ارسال الرساله بنجاح")
            this.message.errors = {};
            this.message = {
                name:"",
                email:"",
                email : "",
                age:null,
                phone:null,
                title:"",
                message:"",
                errors:[]
            }
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
  }
};
</script>



<style scoped>
.swal2-container {
  z-index: 100000000000 !important
}
::ng-deep.swal2-container {
    z-index: 1000000;
}
.swal-overlay {
    z-index: 100000000000 !important;
}
.title {
  color: #3a9bd6;
  font-size: 14px;
  font-family: Cairo;
  font-weight: 700;
  word-wrap: break-word;
}
@media only screen and (max-width: 991px) {
  .prag {
    width: 100% !important;
    text-align: center !important;
  }
  .subject {
    width: 100% !important;
    text-align: center !important;
  }
}
</style>
