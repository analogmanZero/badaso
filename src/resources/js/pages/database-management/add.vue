<template>
  <div>
    <badaso-breadcrumb-row></badaso-breadcrumb-row>
    <vs-row v-if="$helper.isAllowed('add_database')">
      <vs-col vs-lg="12">
        <vs-card>
          <div slot="header">
            <h3>{{ $t("database.add.title") }}</h3>
          </div>
          <vs-row vs-align="center">
            <vs-col vs-lg="12" vs-align="center">
              <badaso-text
                v-model="databaseData.table"
                size="12"
                :label="$t('database.add.field.table')"
                :placeholder="$t('database.add.field.table')"
                required
                autofocus
              >
              </badaso-text>
            </vs-col>
            <vs-col vs-lg="12">
              <div v-if="$v.databaseData.table.$dirty" class="d-inline-grid">
                <i18n path="vuelidate.required" style="color: rgba(var(--vs-danger), 1)" v-if="!$v.databaseData.table.required" >
                  {{ $t("database.add.row.field.tableName") }}
                </i18n>

                <i18n path="vuelidate.alphaNumAndUnderscoreValidator" style="color: rgba(var(--vs-danger), 1)" v-if="!$v.databaseData.table.alphaNumAndUnderscoreValidator" >
                  {{ $t("database.add.row.field.tableName") }}
                </i18n>

                <i18n path="vuelidate.maxLength" style="color: rgba(var(--vs-danger), 1)" v-if="!$v.databaseData.table.maxLength" >
                  <template v-slot:field>
                    {{ $t("database.add.row.field.tableName") }}
                  </template>
                  <template v-slot:length>
                    {{ $v.databaseData.table.$params.maxLength.max }}
                  </template>
                </i18n>
              </div>
            </vs-col>
          </vs-row>
        </vs-card>
      </vs-col>
      <vs-col vs-lg="12">
        <vs-card>
          <div slot="header">
            <h3>{{ $t("database.add.row.title") }}</h3>
            <span style="color: rgba(var(--vs-danger), 1)">
              <i18n path="database.warning.docs">
                <a
                  target="_blank"
                  href="https://badaso-docs.uatech.co.id/docs/en/core-concept/database-management/"
                  >docs</a
                >
              </i18n>
            </span>
          </div>
          <vs-row vs-justify="center" vs-align="center">
            <vs-col col-lg="12" style="overflow-x: auto">
              <vs-table :data="databaseData.rows">
                <template slot="thead">
                  <vs-th style="word-wrap: nowrap">
                    {{ $t("database.add.row.field.fieldName") }}
                  </vs-th>
                  <vs-th style="word-wrap: nowrap">
                    {{ $t("database.add.row.field.fieldType") }}
                  </vs-th>
                  <vs-th style="word-wrap: nowrap">
                    {{ $t("database.add.row.field.fieldLength") }}
                  </vs-th>
                  <vs-th style="word-wrap: nowrap">
                    {{ $t("database.add.row.field.fieldNull") }}
                  </vs-th>
                  <vs-th style="word-wrap: nowrap">
                    {{ $t("database.add.row.field.fieldAttribute") }}
                  </vs-th>
                  <vs-th style="word-wrap: nowrap">
                    {{ $t("database.add.row.field.fieldIncrement") }}
                  </vs-th>
                  <vs-th style="word-wrap: nowrap">
                    {{ $t("database.add.row.field.fieldIndex") }}
                  </vs-th>
                  <vs-th style="word-wrap: nowrap">
                    {{ $t("database.add.row.field.fieldDefault") }}
                  </vs-th>
                  <vs-th style="word-wrap: nowrap"></vs-th>
                </template>
                <template slot-scope="{ data }">
                  <template v-for="(tr, indextr) in data">
                    <vs-tr :key="indextr">
                      <vs-td :data="tr.fieldName">
                        <vs-input
                          type="text"
                          required
                          v-model="tr.fieldName"
                          class="inputx"
                        />
                      </vs-td>

                      <vs-td :data="tr.fieldType">
                        <vs-select
                          class="selectExample"
                          v-model="tr.fieldType"
                          style="width: 100%"
                        >
                          <div
                            :key="index"
                            v-for="(item, index) in fieldTypeList"
                          >
                            <vs-select-group
                              :title="item.title"
                              v-if="item.group"
                            >
                              <vs-select-item
                                :key="index"
                                :value="item.value"
                                :text="item.label"
                                v-for="(item, index) in item.group"
                              />
                            </vs-select-group>
                          </div>
                        </vs-select>
                      </vs-td>

                      <vs-td :data="tr.fieldLength">
                        <vs-input
                          type="text"
                          required
                          v-model="tr.fieldLength"
                          class="inputx"
                        />
                      </vs-td>

                      <vs-td :data="tr.fieldNull">
                        <vs-checkbox v-model="tr.fieldNull"></vs-checkbox>
                      </vs-td>

                      <vs-td :data="tr.fieldAttribute">
                        <vs-checkbox v-model="tr.fieldAttribute"></vs-checkbox>
                      </vs-td>

                      <vs-td :data="tr.fieldIncrement">
                        <vs-checkbox v-model="tr.fieldIncrement"></vs-checkbox>
                      </vs-td>

                      <vs-td :data="tr.fieldIndex">
                        <vs-select
                          class="selectExample"
                          v-model="tr.fieldIndex"
                          style="width: 100%"
                        >
                          <vs-select-item
                            :key="index"
                            :value="item.value"
                            :text="item.label"
                            v-for="(item, index) in fieldIndexList"
                          />
                        </vs-select>
                      </vs-td>

                      <vs-td :data="tr.fieldDefault">
                        <vs-input
                          type="text"
                          v-model="tr.fieldDefault"
                          class="inputx"
                        />
                      </vs-td>

                      <vs-td>
                        <vs-button
                          color="danger"
                          type="relief"
                          @click="dropField(indextr)"
                        >
                          <vs-icon icon="delete"></vs-icon>
                        </vs-button>
                      </vs-td>
                    </vs-tr>

                    <!-- VALIDATION MESSAGE SECTION -->
                    <vs-tr :key="'validation-' + indextr">

                      <!-- FIELD NAME -->
                      <vs-td>
                        <!-- required -->
                        <i18n path="vuelidate.required" style="color: rgba(var(--vs-danger), 1)" v-if="!$v.databaseData.rows.$each[indextr].fieldName.required" >
                          {{ $t("database.add.row.field.fieldName") }}
                        </i18n>

                        <!-- maxLength -->
                        <i18n path="vuelidate.maxLength" style="color: rgba(var(--vs-danger), 1)" v-if="!$v.databaseData.rows.$each[indextr].fieldName.maxLength" >
                          <template v-slot:field>
                            {{ $t("database.add.row.field.fieldName") }}
                          </template>
                          <template v-slot:length>
                            {{ $v.databaseData.table.$params.maxLength.max }}
                          </template>
                        </i18n>

                        <!-- alphaNumAndUnderscoreValidator -->
                        <i18n path="vuelidate.alphaNumAndUnderscoreValidator" style="color: rgba(var(--vs-danger), 1)" v-if="!$v.databaseData.rows.$each[indextr].fieldName.alphaNumAndUnderscoreValidator" >
                          {{ $t("database.add.row.field.fieldName") }}
                        </i18n>

                        <!-- unique -->
                        <i18n path="vuelidate.unique" style="color: rgba(var(--vs-danger), 1)" v-if="!$v.databaseData.rows.$each[indextr].fieldName.unique" >
                          {{ $t("database.add.row.field.fieldName") }}
                        </i18n>
                      </vs-td>

                      <!-- FIELD TYPE -->
                      <vs-td>
                        <!-- required -->
                        <i18n path="vuelidate.required" style="color: rgba(var(--vs-danger), 1)" v-if="!$v.databaseData.rows.$each[indextr].fieldType.required" >
                          {{ $t("database.add.row.field.fieldType") }}
                        </i18n>
                      </vs-td>

                      <!-- FIELD LENGTH -->
                      <vs-td>
                        <!-- requiredIf -->
                        <i18n path="vuelidate.required" style="color: rgba(var(--vs-danger), 1)" v-if="!$v.databaseData.rows.$each[indextr].fieldLength.required" >
                          {{ $t("database.add.row.field.fieldLength") }}
                        </i18n>
                      </vs-td>
                    </vs-tr>
                  </template>
                </template>
              </vs-table>
            </vs-col>
            <vs-col
              vs-w="6"
              class="mt-4 w-unset"
              vs-justify="center"
              vs-align="center"
            >
              <vs-button type="relief" color="primary" @click="addField()">
                <vs-icon icon="add"></vs-icon>
                Add new column
              </vs-button>
              <vs-button type="relief" color="primary" @click="addTimestamps()">
                <vs-icon icon="add"></vs-icon>
                Add timestamps
              </vs-button>

              <!-- TODO for future development -->
              <!-- <vs-button type="relief" color="primary" @click="addSoftDeletes()" >
                <vs-icon icon="add"></vs-icon>
                Add soft deletes
              </vs-button> -->
            </vs-col>
          </vs-row>
        </vs-card>
      </vs-col>
      <vs-col vs-lg="12">
        <vs-card class="action-card">
          <vs-row vs-align="center">
            <vs-col vs-lg="2">
              <vs-button color="primary" type="relief" @click="submitForm()">
                <vs-icon icon="save"></vs-icon> {{ $t("database.add.button") }}
              </vs-button>
            </vs-col>
            <vs-col
              vs-lg="10"
              vs-align="center"
              v-if="$v.databaseData.rows.$dirty"
              class="d-inline-grid"
            >
              <i18n
                path="vuelidate.rowsRequired"
                style="color: rgba(var(--vs-danger), 1)"
                v-if="!$v.databaseData.rows.required"
              >
              </i18n>
            </vs-col>
          </vs-row>
        </vs-card>
      </vs-col>
    </vs-row>
    <vs-row v-else>
      <vs-col vs-lg="12">
        <vs-card>
          <vs-row>
            <vs-col vs-lg="12">
              <h3>{{ $t("database.warning.notAllowed") }}</h3>
            </vs-col>
          </vs-row>
        </vs-card>
      </vs-col>
    </vs-row>
  </div>
</template>

<script>
import { required, requiredIf, maxLength, helpers } from "vuelidate/lib/validators";
const alphaNumAndUnderscoreValidator = helpers.regex(
  "alphaNumAndDot",
  /^[a-zA-Z\d_]*$/i
);

const unique = (group, key) => {
  return (value) => {
    if (value === '') return true

    const found = group.filter((item) => {
      if (key) {
        return item[key] == value;
      }
      return item == value;
    });
    return found.length <= 1;
  };
};

export default {
  name: "DatabaseManagementAdd",
  components: {},
  data: () => ({
    breadcrumb: [],
    databaseData: {
      table: "",
      rows: [],
    },
    fieldTypeList: [],
  }),
  validations() {
    return {
      databaseData: {
        table: {
          required,
          maxLength: maxLength(64),
          alphaNumAndUnderscoreValidator,
        },
        rows: {
          required,
          $each: {
            fieldName: {
              required,
              maxLength: maxLength(64),
              alphaNumAndUnderscoreValidator,
              unique: unique(this.databaseData.rows, "fieldName"),
            },
            fieldType: {
              required,
            },
            fieldLength: {
              required: requiredIf (function (value) {
                return value.fieldType == "double" || value.fieldType == "decimal" || value.fieldType == "float" || value.fieldType == "varchar" || value.fieldType == "char" || value.fieldType == "set" || value.fieldType == "enum"
              })
            },
          },
        },
      },
    };
  },
  computed: {
    fieldIndexList: {
      get() {
        return this.$databaseHelper.getMigrationIndexList();
      },
    },
  },
  mounted() {
    this.getDbmsFieldType();
    this.insertIdToRows();
  },
  methods: {
    getDbmsFieldType() {
      this.$openLoader();
      this.$api.badasoDatabase
        .getType()
        .then((response) => {
          this.$closeLoader();
          this.fieldTypeList = JSON.parse(response.data);
        })
        .catch((error) => {
          this.$closeLoader();
          this.$vs.notify({
            title: this.$t("alert.danger"),
            text: error.message,
            color: "danger",
          });
        });
    },
    submitForm() {
      this.$v.$touch();
      if (!this.$v.$invalid) {
        this.$v.$reset();
        this.$openLoader();
        this.$api.badasoDatabase
          .add(this.databaseData)
          .then((response) => {
            this.$closeLoader();
            this.$vs.notify({
              title: this.$t("alert.success"),
              text: response.data,
              color: "success",
            });
            this.$store.commit("badaso/FETCH_MENU");
            this.$store.commit("badaso/FETCH_USER");
            this.$router.push({ name: "DatabaseManagementBrowse" });
          })
          .catch((error) => {
            let message = error.message;
            this.$closeLoader();
            this.$v.$reset();

            if (error.errors.table) {
              message = error.errors.table[0];
            }

            this.$vs.notify({
              title: this.$t("alert.danger"),
              text: message,
              color: "danger",
            });
          });
      } else {
        if (this.$v.databaseData.rows.$invalid) {
          this.$vs.notify({
            title: this.$t("alert.danger"),
            text: this.$t("database.warning.empty"),
            color: "danger",
          });
        } else if (this.$v.databaseData.$invalid) {
          this.$vs.notify({
            title: this.$t("alert.danger"),
            text: this.$t("database.warning.invalid"),
            color: "danger",
          });
        }
      }
    },
    addField() {
      this.databaseData.rows.push({
        fieldName: "",
        fieldType: "",
        fieldLength: null,
        fieldNull: false,
        fieldAttribute: false,
        fieldIncrement: false,
        fieldIndex: null,
        fieldDefault: "",
      });
    },

    findFieldOnRows(fieldName) {
      let found = false;

      for (let index = 0; index < this.databaseData.rows.length; index++) {
        const element = this.databaseData.rows[index];
        if (element.fieldName == fieldName) {
          found = true;
          break;
        }
      }

      return found;
    },

    addTimestamps() {
      if (this.findFieldOnRows("created_at")) {
        this.$vs.notify({
          title: this.$t("alert.danger"),
          text: this.$t("database.warning.exists", { 0: "created_at" }),
          color: "danger",
        });
      } else {
        this.databaseData.rows.push({
          fieldName: "created_at",
          fieldType: "timestamp",
          fieldLength: null,
          fieldNull: true,
          fieldAttribute: false,
          fieldIncrement: false,
          fieldIndex: null,
          fieldDefault: null,
        });
      }

      if (this.findFieldOnRows("updated_at")) {
        this.$vs.notify({
          title: this.$t("alert.danger"),
          text: this.$t("database.warning.exists", { 0: "updated_at" }),
          color: "danger",
        });
      } else {
        this.databaseData.rows.push({
          fieldName: "updated_at",
          fieldType: "timestamp",
          fieldLength: null,
          fieldNull: true,
          fieldAttribute: false,
          fieldIncrement: false,
          fieldIndex: null,
          fieldDefault: null,
        });
      }
    },

    addSoftDeletes() {
      if (this.findFieldOnRows("deleted_at")) {
        this.$vs.notify({
          title: this.$t("alert.danger"),
          text: this.$t("database.warning.exists", { 0: "deleted_at" }),
          color: "danger",
        });
      } else {
        this.databaseData.rows.push({
          fieldName: "deleted_at",
          fieldType: "timestamp",
          fieldLength: null,
          fieldNull: true,
          fieldAttribute: false,
          fieldIncrement: false,
          fieldIndex: null,
          fieldDefault: null,
        });
      }
    },

    dropField(index) {
      this.$vs.dialog({
        type: "confirm",
        color: "danger",
        title: this.$t("action.delete.title"),
        text: this.$t("action.delete.text"),
        accept: () => this.databaseData.rows.splice(index, 1),
        acceptText: this.$t("action.delete.accept"),
        cancelText: this.$t("action.delete.cancel"),
      });
    },

    insertIdToRows() {
      this.databaseData.rows.push({
        fieldName: "id",
        fieldType: "bigint",
        fieldLength: null,
        fieldNull: false,
        fieldAttribute: true,
        fieldIncrement: true,
        fieldIndex: "primary",
        fieldDefault: null,
      });
    },
  },
};
</script>

<style>
.drag_icon:hover {
  cursor: all-scroll;
}
</style>
