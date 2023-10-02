<template>
  <div>
    <WidgetsStatsA />
    <!-- <CRow>
      <CCol :md="12">
        <CCard class="mb-4">
          <CCardBody>
            <CRow>
              <CCol :sm="5">
                <h4 id="traffic" class="card-title mb-0">Traffic</h4>
                <div class="small text-medium-emphasis">January 2021</div>
              </CCol>
              <CCol :sm="7" class="d-none d-md-block">
                <CButton color="primary" class="float-end">
                  <CIcon icon="cil-cloud-download" />
                </CButton>
                <CButtonGroup
                  class="float-end me-3"
                  role="group"
                  aria-label="Basic outlined example"
                >
                  <CButton color="secondary" variant="outline">Day</CButton>
                  <CButton color="secondary" variant="outline" active
                    >Month</CButton
                  >
                  <CButton color="secondary" variant="outline">Year</CButton>
                </CButtonGroup>
              </CCol>
            </CRow>
            <CRow>
              <MainChartExample
                style="height: 300px; max-height: 300px; margin-top: 40px"
              />
            </CRow>
          </CCardBody>
          <CCardFooter>
            <CRow :xs="{ cols: 1 }" :md="{ cols: 5 }" class="text-center">
              <CCol class="mb-sm-2 mb-0">
                <div class="text-medium-emphasis">Visits</div>
                <strong>29.703 Users (40%)</strong>
                <CProgress
                  class="mt-2"
                  color="success"
                  thin
                  :precision="1"
                  :value="40"
                />
              </CCol>
              <CCol class="mb-sm-2 mb-0 d-md-down-none">
                <div class="text-medium-emphasis">Unique</div>
                <strong>24.093 Users (20%)</strong>
                <CProgress
                  class="mt-2"
                  color="info"
                  thin
                  :precision="1"
                  :value="20"
                />
              </CCol>
              <CCol class="mb-sm-2 mb-0">
                <div class="text-medium-emphasis">Pageviews</div>
                <strong>78.706 Views (60%)</strong>
                <CProgress
                  class="mt-2"
                  color="warning"
                  thin
                  :precision="1"
                  :value="60"
                />
              </CCol>
              <CCol class="mb-sm-2 mb-0">
                <div class="text-medium-emphasis">New Users</div>
                <strong>22.123 Users (80%)</strong>
                <CProgress
                  class="mt-2"
                  color="danger"
                  thin
                  :precision="1"
                  :value="80"
                />
              </CCol>
              <CCol class="mb-sm-2 mb-0 d-md-down-none">
                <div class="text-medium-emphasis">Bounce Rate</div>
                <strong>Average Rate (40.15%)</strong>
                <CProgress class="mt-2" :value="40" thin :precision="1" />
              </CCol>
            </CRow>
          </CCardFooter>
        </CCard>
      </CCol>
    </CRow> -->
    <!-- <WidgetsStatsD /> -->
    <CRow>
      <CCol :md="12">
        <CCard class="mb-4">
          <CCardHeader> اخر &amp; الرسايل التي لم تري </CCardHeader>
          <CCardBody>
            <CTable align="middle" class="mb-0 border" hover responsive>
              <CTableHead color="light">
                <CTableRow>
                  <CTableHeaderCell class="text-center">
                    <CIcon name="cil-people" />
                  </CTableHeaderCell>
                  <CTableHeaderCell>الاسم</CTableHeaderCell>
                  <CTableHeaderCell class="text-center"
                    >الايميل</CTableHeaderCell
                  >
                  <CTableHeaderCell>العمر</CTableHeaderCell>
                  <CTableHeaderCell class="text-center"
                    >الحاله</CTableHeaderCell
                  >
                  <CTableHeaderCell>الموبيل</CTableHeaderCell>
                  <CTableHeaderCell>التحكم</CTableHeaderCell>
                </CTableRow>
              </CTableHead>
              <CTableBody>
                <CTableRow v-for="message in LastMessages" :key="message.id">
                  <CTableDataCell class="text-center">
                    <CAvatar size="md" src="./images/avatar.jpg" />
                  </CTableDataCell>
                  <CTableDataCell>
                    <div>{{ message.name }}</div>
                    <div class="small text-medium-emphasis">
                      <span>{{ formateDate(message.createdAt).date }}</span>
                    </div>
                  </CTableDataCell>
                  <CTableDataCell>
                    <div>{{ message.email }}</div>
                  </CTableDataCell>
                  <CTableDataCell>
                    <div>{{ message.age }}</div>
                  </CTableDataCell>
                  <CTableDataCell>
                    <div
                      :class="
                        message.isSeen
                          ? 'badge badge-pill badge-success'
                          : 'badge badge-pill badge-danger'
                      "
                    >
                      {{ message.isSeen ? "مرئي" : "غير مرئي" }}
                    </div>
                  </CTableDataCell>
                  <CTableDataCell>
                    <div>{{ message.phone }}</div>
                  </CTableDataCell>
                  <CTableDataCell>
                    <div class="dropdown" style="text-align: left">
                      <button
                        aria-expanded="false"
                        aria-haspopup="true"
                        class="btn ripple btn-primary btn-sm d-flex"
                        data-toggle="dropdown"
                        type="button"
                      >
                        العمليات
                        <i class="fas fa-caret-down ml-1"></i>
                      </button>
                      <div class="dropdown-menu tx-13">
                        <router-link
                          class="modal-effect dropdown-item text-right"
                          :to="'/dashboard/contact-us/' + message.id"
                          ><i class="text-success fas fa-eye"></i
                          >&nbsp;&nbsp;عرض الرساله</router-link
                        >
                      </div>
                    </div>
                  </CTableDataCell>
                </CTableRow>
                <CTableRow> </CTableRow>
              </CTableBody>
            </CTable>
          </CCardBody>
        </CCard>
        <CCard class="mb-4">
          <CCardHeader> اخر &amp; التسجيلات التي تم التسجيل فيها </CCardHeader>
          <CCardBody>
            <CTable align="middle" class="mb-0 border" hover responsive>
              <CTableHead color="light">
                <CTableRow>
                  <CTableHeaderCell class="text-center">
                    <CIcon name="cil-people" />
                  </CTableHeaderCell>
                  <CTableHeaderCell>الاسم</CTableHeaderCell>
                  <CTableHeaderCell class="text-center"
                    >الايميل</CTableHeaderCell
                  >
                  <CTableHeaderCell>العمر</CTableHeaderCell>
                  <CTableHeaderCell class="text-center"
                    >الحاله</CTableHeaderCell
                  >
                  <CTableHeaderCell>الحدث</CTableHeaderCell>
                  <CTableHeaderCell>التحكم</CTableHeaderCell>
                </CTableRow>
              </CTableHead>
              <CTableBody>
                <CTableRow v-for="record in Recordings" :key="record.id">
                  <CTableDataCell class="text-center">
                    <CAvatar size="md" src="./images/avatar.jpg" />
                  </CTableDataCell>
                  <CTableDataCell>
                    <div>{{ record.name }}</div>
                    <div class="small text-medium-emphasis">
                      <span>{{ formateDate(record.createdAt).date }}</span>
                    </div>
                  </CTableDataCell>
                  <CTableDataCell>
                    <div>{{ record.email }}</div>
                  </CTableDataCell>
                  <CTableDataCell>
                    <div>{{ record.age }}</div>
                  </CTableDataCell>
                  <CTableDataCell>
                    <div
                      :class="
                        record.isSeen
                          ? 'badge badge-pill badge-success'
                          : 'badge badge-pill badge-danger'
                      "
                    >
                      {{ record.isSeen ? "مرئي" : "غير مرئي" }}
                    </div>
                  </CTableDataCell>
                  <CTableDataCell>
                    <div>
                      <router-link
                        :to="'/dashboard/Events/' + record.event.id"
                        >{{ record.event.name }}</router-link
                      >
                    </div>
                  </CTableDataCell>
                  <CTableDataCell>
                    <div class="dropdown" style="text-align: left">
                      <button
                        aria-expanded="false"
                        aria-haspopup="true"
                        class="btn ripple btn-primary btn-sm d-flex"
                        data-toggle="dropdown"
                        type="button"
                      >
                        العمليات
                        <i class="fas fa-caret-down ml-1"></i>
                      </button>
                      <div class="dropdown-menu tx-13">
                        <router-link
                          class="modal-effect dropdown-item text-right"
                          :to="'/dashboard/event-recording/' + record.id"
                          ><i class="text-success fas fa-eye"></i
                          >&nbsp;&nbsp;عرض التسجيل</router-link
                        >
                      </div>
                    </div>
                  </CTableDataCell>
                </CTableRow>
                <CTableRow> </CTableRow>
              </CTableBody>
            </CTable>
          </CCardBody>
        </CCard>
      </CCol>
    </CRow>
  </div>
</template>

<script>
import MainChartExample from "./charts/MainChartExample";
import WidgetsStatsA from "./widgets/WidgetsStatsTypeA.vue";
import WidgetsStatsD from "./widgets/WidgetsStatsTypeD.vue";

export default {
  name: "Dashboard",
  components: {
    MainChartExample,
    WidgetsStatsA,
    WidgetsStatsD,
  },
  data: () => {
    return {
      LastMessages: [],
      Recordings: [],
    };
  },
  methods: {
    formateDate(date) {
      return {
        date: moment(date).format("L"),
        time: moment(date).format(" h:mm:ss a"),
      };
    },
    getLastMessages() {
      axios
        .get("/api/admin/contact/lastMessage")
        .then((result) => {
          if (result.data.status == true) {
            this.LastMessages = result.data.messages;
          } else if (result.data.status == null) {
            Toast.fire({
              icon: "error",
              title: result.data.error,
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
    getLastRecordings() {
      axios
        .get("/api/admin/event-recordings/lastRecordings")
        .then((result) => {
          if (result.data.status == true) {
            this.Recordings = result.data.last_recordings;
          } else if (result.data.status == null) {
            Toast.fire({
              icon: "error",
              title: result.data.error,
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
    this.getLastMessages();
    this.getLastRecordings();
  },
};
</script>
