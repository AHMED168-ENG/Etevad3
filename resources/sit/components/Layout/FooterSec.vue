<template>
  <!-- Remove the container if you want to extend the Footer to full width. -->
  <div class="footer" style="position: relative">
    <!-- Footer -->
    <footer class="text-center text-lg-start text-white container">
      <!-- Grid container -->
      <div class="pb-0">
        <!-- Section: Links -->
        <section class="">
          <!--Grid row-->
          <div class="row pt-4">
            <!-- Grid column -->
            <div
              class="col-7 col-md-6 col-lg-2 col-xl-3 mx-auto mt-3"
              style="text-align: right"
            >
              <a href="">
                <img class="mb-4" :src="'./images/seting/' + seting.site_lower_logo"
              /></a>
              <div class="mb-4">
                <p class="title">
                  <span><img src="../../assets/photos/Location.svg" /></span>
                  العنوان
                </p>
                <p class="para">
                  {{ seting.site_address }}
                </p>
              </div>

              <div class="nile">
                <p class="title">
                  <span><img src="../../assets/photos/Call.svg" /></span> الهاتف
                </p>
                <p class="para">
                  <a
                    href="tel:+966116027234"
                    style="text-decoration: none; color: white"
                    >{{ seting.site_phone }}</a
                  >
                </p>
              </div>

              <div>
                <p class="title">
                  <span><img src="../../assets/photos/Message.png" /></span>
                  البريد الإلكتروني
                </p>
                <p class="para">
                  <a
                    :href="'mailto:' + seting.site_email"
                    style="text-decoration: none; color: white"
                    >{{ seting.site_email }}</a
                  >
                </p>
              </div>
            </div>
            <!-- Grid column -->

            <!-- <hr class="w-100 clearfix d-md-none" /> -->

            <!-- Grid column -->
            <div class="col-5 col-md-6 col-lg-2 col-xl-2 mx-auto Deta">
              <p class="title">أقسام الموقع</p>
              <ul class="d-flex flex-column gap-3">
                <li><router-link class="lin" to="/achievemnet">البطولات</router-link></li>
                <li><router-link class="lin" to="/motivate">المركز الإعلامي</router-link></li>
                <li><router-link class="lin" to="/about">عن الإتحاد</router-link></li>
                <li><router-link class="lin" to="/action">الفعاليات</router-link></li>
              </ul>
            </div>
            <!-- Grid column -->

            <!-- Grid column -->
            <div class="col-md-3 col-lg-2 col-xl-2 mx-auto mt-3 Detaa">
              <h6
                class="text-uppercase mb-4 font-weight-bold"
                style="text-align: right; line-height: 35px"
              >
                ادخل بريدك الإلكتروني ليصلك كل جديد
              </h6>
              <div class="d-flex bg-white Email">
                <input
                  id="input"
                  type="text"
                  placeholder=" ادخل البريد الالكتروني ..."
                />
                <router-link to="contact" class="send" style="text-decoration: none">ارسال</router-link>
              </div>
            </div>

            <!-- Grid column -->
            <!-- <hr class="w-100 clearfix d-md-none" /> -->

            <!-- Grid column -->
            <div class="ima col-md-4 col-lg-3 col-xl-3 mx-auto mt-3">
              <img
                src="../../assets/photos/send.png"
                alt=""
                class="footerr"
                style="margin-top: 98px; padding-right: 56px"
              />
            </div>
            <!-- Grid column -->
          </div>
          <!--Grid row-->
        </section>

        <!-- Section: Copyright -->
        <section class="p-3 pt-0">
          <div class="row d-flex align-items-center">
            <!-- Grid column -->
            <div class="text-center">
              <!-- Copyright -->
              <div class="p p-3 copyRight" v-html="seting.copyrights"></div>
              <!-- Copyright -->
            </div>
            <!-- Grid column -->
          </div>
        </section>
        <!-- Section: Copyright -->
      </div>
      <!-- Grid container -->
    </footer>
    <!-- Footer -->
  </div>
  <!-- End of .container -->
</template>

<script>
export default {
  data() {
    return {
      seting:{},
    }
  },
  methods:{

  },
  created() {
    setTimeout(() => {
      this.seting = this.$store.getters.getSeting
    }, 1000);
  }
};
</script>

<style scoped>
.copyRight p {
    margin: 0 !important;
}
.copyRight a {
    color:#eee !important
}
footer {
}
.title {
  color: #3a9bd6;
  font-size: 14px;
  font-family: Cairo;
  font-weight: 700;
  word-wrap: break-word;
  text-align: right;
}
.para {
  color: white;
  font-size: 14px;
  font-family: Cairo;
  font-weight: 400;
  line-height: 24px;
  word-wrap: break-word;
  text-align: right;
}
.Deta {
  padding-top: 125px;
}
.Detaa {
  padding-top: 125px;
}
.lin {
  text-decoration: none;
  color: #ffffff;
  text-align: right;
}
ul {
  list-style-type: none;
  text-align: right;
  margin: 0;
  padding: 0;
}
.send {
  padding-left: 40px;
  padding-right: 40px;
  padding-top: 10px;
  padding-bottom: 10px;
  background: #d2398d;
  border-radius: 10px;
  border: none;
  color: #ffffff;
  font-weight: bold;
}

#input {
  padding: 5px;
  border-radius: 15px;
  border: none;
}
.Email {
  width: 320px;
  padding: 10px;
  border-radius: 15px;
}

.footer {
  background: linear-gradient(180deg, #022c48 0%, #306386 100%);

  clip-path: polygon(0% 20%, 100% 0%, 100% 100%, 0% 100%);
}
.footerr {
  width: 90%;
}
.p {
  font-size: 13px !important;
}
@media only screen and (min-width: 991px) and (max-width: 800px) {
}
@media only screen and (max-width: 991px) {
  .new_button2 {
    display: block;
  }
  .new_button1 {
    display: none;
  }
  .nile {
    padding-top: 50px;
  }
  .footerr {
    display: none;
  }
  .Detaa {
    padding-top: 10px !important;
  }
  p {
    font-size: 15px !important;
  }
  .footer {
    background: linear-gradient(180deg, #022c48 0%, #306386 100%);
    clip-path: polygon(0% 0%, 100% 0%, 100% 100%, 0% 100%);
  }
}
</style>
