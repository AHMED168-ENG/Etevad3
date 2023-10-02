<template>
  <div class="recording">
    <div class="row row-sm">
      <SmartTable></SmartTable>
      <div class="col-xl-12">
        <div class="card mg-b-20">
          <div class="card-body">
            <div class="table-responsive">
              <div class="card-body">
                <form class="form" @supmit="(e) => e.prrecordingDefault()">
                  <div class="form-body">
                    <h4 class="form-section">
                      <i class="ft-home"></i> بيانات التسجيل
                    </h4>

                    <div>
                      <div class="form-contole">
                        <label class="form-controle">الاسم</label>
                        <input
                          autocomplete="on"
                          :class="[
                            'form-control',
                            recording.errors.name ? 'is-invalid' : '',
                          ]"
                          type="text"
                          readonly
                          v-model="recording.data.name"
                        />
                        <span
                          v-if="recording.errors.name"
                          class="invalid-feedback"
                        >
                          {{ recording.errors.name[0] }}
                        </span>
                      </div>

                      <div class="form-contole">
                        <label class="form-controle">الايمل</label>
                        <input
                          autocomplete="on"
                          :class="[
                            'form-control',
                            recording.errors.email ? 'is-invalid' : '',
                          ]"
                          type="text"
                          readonly
                          v-model="recording.data.email"
                        />
                        <span
                          v-if="recording.errors.email"
                          class="invalid-feedback"
                        >
                          {{ recording.errors.email[0] }}
                        </span>
                      </div>

                      <div class="form-contole">
                        <label class="form-controle">العمر</label>
                        <input
                          autocomplete="on"
                          :class="[
                            'form-control',
                            recording.errors.age ? 'is-invalid' : '',
                          ]"
                          type="number"
                          readonly
                          v-model="recording.data.age"
                        />
                        <span
                          v-if="recording.errors.age"
                          class="invalid-feedback"
                        >
                          {{ recording.errors.age[0] }}
                        </span>
                      </div>

                      <div class="form-contole">
                        <label class="form-controle">الموبيل</label>
                        <input
                          autocomplete="on"
                          :class="[
                            'form-control',
                            recording.errors.mobile ? 'is-invalid' : '',
                          ]"
                          type="text"
                          readonly
                          v-model="recording.data.mobile"
                        />
                        <span
                          v-if="recording.errors.mobile"
                          class="invalid-feedback"
                        >
                          {{ recording.errors.mobile[0] }}
                        </span>
                      </div>

                      <div class="form-contole">
                        <label class="form-controle">التاريخ</label>
                        <input
                          :class="['form-control']"
                          type="text"
                          readonly
                          :value="formateDate(recording.data.createdAt).date"
                        />
                        <span
                          v-if="recording.errors.mobile"
                          class="invalid-feedback"
                        >
                          {{ recording.errors.mobile[0] }}
                        </span>
                      </div>

                      <div class="form-contole">
                        <label class="form-controle">الحدث</label>
                        <input
                          :class="['form-control']"
                          type="text"
                          readonly
                          :value="
                            recording.data.event
                              ? recording.data.event.name
                              : ''
                          "
                        />
                        <span
                          v-if="recording.errors.mobile"
                          class="invalid-feedback"
                        >
                          {{ recording.errors.mobile[0] }}
                        </span>
                      </div>

                      <div class="form-contole">
                        <label class="form-label">الرؤيه </label>
                        <select
                          readonly
                          aria-readonly="true"
                          v-model="recording.data.is_seen"
                          id="select-beast"
                          class="form-control nice-select custom-select"
                        >
                          <option value="1">مرئي</option>
                          <option value="0">غير مرئي</option>
                        </select>
                        <span
                          v-if="recording.errors.is_seen"
                          class="invalid-feedback"
                        >
                          {{ recording.errors.is_seen[0] }}
                        </span>
                      </div>
                    </div>
                  </div>
                  <br />
                  <!-- <div class="form-actions">
                    <button
                      type="submit"
                      class="btn btn-primary btn-block"
                      @click="updateRecording"
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
  name: "recordingDetails",
  data: () => {
    return {
      changeImage: false,
      recording: {
        data: {
          id: "",
          name: "",
          email: "",
          age: 0,
          mobile: 0,
          is_seen: 0,
        },
        errors: [],
      },
    };
  },
  methods: {
    // ================= start part update recording =======================
    updateRecording() {
      axios
        .put(
          "/api/admin/event-recordings/update/" + this.recording.data.id,
          this.recording.data
        )
        .then((result) => {
          if (result.data.status == true) {
            Toast.fire({
              icon: "success",
              title: "تم تحديث بيانات التسجيل بنجاح",
            });
            this.recording.errors = {};
          } else if (result.data.status == null) {
            Toast.fire({
              icon: "error",
              title: result.data.error,
            });
          } else {
            this.recording.errors = result.data.errors;
          }
        })
        .catch((error) => {
          Toast.fire({
            icon: "error",
            title: error,
          });
        });
    },
    // ================= end part update recording =======================
    // ================= start part get recording  =======================
    getRecording() {
      axios
        .get("/api/admin/event-recordings/show/" + this.$route.params.id)
        .then((res) => {
          if (res.data.status == true) {
            this.recording.data = res.data.event_recording;
            console.log(this.recording.data);
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
    // ================= end part get recording  =======================
    formateDate(date) {
      return {
        date: moment(date).format("L"),
        time: moment(date).format(" h:mm:ss a"),
      };
    },
  },
  created() {
    this.getRecording();
  },
};
</script>

<style lang="scss" scoped>
.profile-recording-img {
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
