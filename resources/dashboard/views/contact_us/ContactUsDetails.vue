<template>
  <div class="message">
    <div class="row row-sm">
      <SmartTable></SmartTable>
      <div class="col-xl-12">
        <div class="card mg-b-20">
          <div class="card-body">
            <div class="table-responsive">
              <div class="card-body">
                <form class="form" @supmit="(e) => e.prmessageDefault()">
                  <div class="form-body">
                    <h4 class="form-section">
                      <i class="ft-home"></i> بيانات الرساله
                    </h4>

                    <div>
                      <div class="form-contole">
                        <label class="form-controle">الاسم</label>
                        <input
                          autocomplete="on"
                          :class="[
                            'form-control',
                            message.errors.name ? 'is-invalid' : '',
                          ]"
                          type="text"
                          readonly
                          v-model="message.data.name"
                        />
                        <span
                          v-if="message.errors.name"
                          class="invalid-feedback"
                        >
                          {{ message.errors.name[0] }}
                        </span>
                      </div>

                      <div class="form-contole">
                        <label class="form-controle">الايمل</label>
                        <input
                          autocomplete="on"
                          :class="[
                            'form-control',
                            message.errors.email ? 'is-invalid' : '',
                          ]"
                          type="text"
                          readonly
                          v-model="message.data.email"
                        />
                        <span
                          v-if="message.errors.email"
                          class="invalid-feedback"
                        >
                          {{ message.errors.email[0] }}
                        </span>
                      </div>

                      <div class="form-contole">
                        <label class="form-controle">العمر</label>
                        <input
                          autocomplete="on"
                          :class="[
                            'form-control',
                            message.errors.age ? 'is-invalid' : '',
                          ]"
                          type="number"
                          readonly
                          v-model="message.data.age"
                        />
                        <span
                          v-if="message.errors.age"
                          class="invalid-feedback"
                        >
                          {{ message.errors.age[0] }}
                        </span>
                      </div>

                      <div class="form-contole">
                        <label class="form-controle">الموبيل</label>
                        <input
                          autocomplete="on"
                          :class="[
                            'form-control',
                            message.errors.phone ? 'is-invalid' : '',
                          ]"
                          type="text"
                          readonly
                          v-model="message.data.phone"
                        />
                        <span
                          v-if="message.errors.phone"
                          class="invalid-feedback"
                        >
                          {{ message.errors.phone[0] }}
                        </span>
                      </div>

                      <div class="form-contole">
                        <label class="form-controle">عنوان الرساله</label>
                        <input
                          autocomplete="on"
                          :class="[
                            'form-control',
                            message.errors.title ? 'is-invalid' : '',
                          ]"
                          type="text"
                          readonly
                          v-model="message.data.title"
                        />
                        <span
                          v-if="message.errors.title"
                          class="invalid-feedback"
                        >
                          {{ message.errors.title[0] }}
                        </span>
                      </div>

                      <div class="form-contole">
                        <label class="form-controle">محتوي الرساله</label>
                        <textarea
                          readonly
                          name=""
                          id=""
                          :class="[
                            'form-control',
                            message.errors.message ? 'is-invalid' : '',
                          ]"
                          v-model="message.data.message"
                        ></textarea>
                        <span
                          v-if="message.errors.message"
                          class="invalid-feedback"
                        >
                          {{ message.errors.message[0] }}
                        </span>
                      </div>
                      <div class="form-contole">
                        <label class="form-controle">التاريخ</label>
                        <input
                          :class="['form-control']"
                          type="text"
                          readonly
                          :value="formateDate(message.data.createdAt).date"
                        />
                        <span
                          v-if="message.errors.mobile"
                          class="invalid-feedback"
                        >
                          {{ message.errors.mobile[0] }}
                        </span>
                      </div>
                      <div class="form-contole">
                        <label class="form-label">الرؤيه </label>
                        <select
                          readonly
                          aria-readonly="true"
                          v-model="message.data.is_seen"
                          id="select-beast"
                          class="form-control nice-select custom-select"
                        >
                          <option value="1">مرئي</option>
                          <option value="0">غير مرئي</option>
                        </select>
                        <span
                          v-if="message.errors.is_seen"
                          class="invalid-feedback"
                        >
                          {{ message.errors.is_seen[0] }}
                        </span>
                      </div>
                    </div>
                  </div>
                  <br />
                  <!-- <div class="form-actions">
                    <button
                      type="submit"
                      class="btn btn-primary btn-block"
                      @click="updateMessage"
                    >
                      <i class="la la-check-square-o"></i>
                      حفظ
                    </button>
                  </div> -->
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "messageDetails",
  data: () => {
    return {
      changeImage: false,
      message: {
        data: {
          id: "",
          name: "",
          email: "",
          age: 0,
          phone: 0,
          title: "",
          message: "",
          is_seen: 0,
        },
        errors: [],
      },
    };
  },
  methods: {
    // ================= start part update message =======================
    updateMessage() {
      axios
        .put(
          "/api/admin/message/update/" + this.message.data.id,
          this.message.data
        )
        .then((result) => {
          if (result.data.status == true) {
            Toast.fire({
              icon: "success",
              title: "تم تحديث بيانات الرساله بنجاح",
            });
            this.message.errors = {};
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
    // ================= end part update message =======================
    formateDate(date) {
      return {
        date: moment(date).format("L"),
        time: moment(date).format(" h:mm:ss a"),
      };
    },
    // ================= start part get message  =======================
    getMessage() {
      axios
        .get("/api/admin/contact/show/" + this.$route.params.id)
        .then((res) => {
          if (res.data.status == true) {
            this.message.data = res.data.message;
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
    // ================= end part get message  =======================
  },
  created() {
    this.getMessage();
  },
};
</script>

<style lang="scss" scoped>
.profile-message-img {
  border-radius: 50%;
  width: 100%;
  height: 100%;
}

.avatar-upload {
  position: relative;
  width: 8.5%;
  aspect-ratio: 1/1;
  margin: auto;
  margin-bottom: 20px;
  border: 1px solid #ddd;
  border-radius: 50%;
  box-shadow: 0px 2px 4px 0px rgba(0, 0, 0, 0.12);
  padding: 2px;
  .avatar-preview {
    width: 100%;
    height: 100%;
  }
  .avatar-edit {
    position: absolute;
    right: 1px;
    z-index: 1;
    top: 90px;
    input {
      display: none;
      + label {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 34px;
        height: 34px;
        margin-bottom: 0;
        border-radius: 100%;
        background: #ffffff;
        border: 1px solid #d2d6de;
        box-shadow: 0px 2px 4px 0px rgba(0, 0, 0, 0.12);
        cursor: pointer;
        font-weight: normal;
        transition: all 0.2s ease-in-out;
        &:hover {
          background: #f1f1f1;
          border-color: #d6d6d6;
        }
      }
    }
  }
}
</style>
