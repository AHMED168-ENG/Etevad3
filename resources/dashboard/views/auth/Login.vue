<template>
  <div class="bg-light min-vh-100 d-flex flex-row align-items-center">
    <CContainer>
      <CRow class="justify-content-center">
        <CCol :md="8">
          <CCardGroup>
            <CCard class="p-4">
              <CCardBody>
                <CForm>
                  <h1>تسجيل الدخول</h1>
                  <p class="text-medium-emphasis">سجل الدخول الي حسابك</p>
                  <CInputGroup class="mb-3">
                    <CInputGroupText>
                      <CIcon icon="cil-user" />
                    </CInputGroupText>
                    <CFormInput
                      placeholder="الايميل"
                      autocomplete="email"
                      v-model="user.email"
                      type="email"
                    />
                    <span
                      v-if="user.errors.email"
                      class="invalid-feedback d-block"
                    >
                      {{ user.errors.email[0] }}
                    </span>
                  </CInputGroup>
                  <CInputGroup class="mb-4">
                    <CInputGroupText>
                      <CIcon icon="cil-lock-locked" />
                    </CInputGroupText>
                    <CFormInput
                      type="password"
                      placeholder="الرقم السري"
                      autocomplete="current-password"
                      v-model="user.password"
                    />
                    <span
                      v-if="user.errors.password"
                      class="invalid-feedback d-block"
                    >
                      {{ user.errors.password[0] }}
                    </span>
                  </CInputGroup>
                  <CRow>
                    <CCol :xs="12">
                      <CButton
                        color="primary"
                        class="px-4 btn-block"
                        @click.prevent="login"
                      >
                        تسجيل
                      </CButton>
                    </CCol>
                    <CCol :xs="12" class="text-right">
                      <!-- <CButton color="link" class="px-0">
                                                Forgot password?
                                            </CButton> -->
                    </CCol>
                  </CRow>
                </CForm>
              </CCardBody>
            </CCard>
          </CCardGroup>
        </CCol>
      </CRow>
    </CContainer>
  </div>
</template>

<script>
export default {
  name: "Login",
  data() {
    return {
      user: { email: "", password: "", errors: {} },
    };
  },
  methods: {
    login() {
      axios
        .post("/api/admin/auth/login", this.user)
        .then(async (result) => {
          this.user.errors = {};
          if (result.data.status == true) {
            Toast.fire({
              icon: "success",
              title: "تم تسجيل الدخول بنجاح",
            });
            this.$store.commit("login", {
              access_token: result.data.access_token,
              data: result.data,
            });
            this.$router.push({ name: "لوحه التحكم" });
          } else if (result.data.status == null) {
            Toast.fire({
              icon: "error",
              title: result.data.error,
            });
          } else {
            this.user.errors = result.data.errors;
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
};
</script>
