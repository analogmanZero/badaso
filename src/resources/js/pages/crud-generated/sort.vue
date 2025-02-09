<template>
  <div>
    <template v-if="!isMaintenance">
      <badaso-breadcrumb-row full> </badaso-breadcrumb-row>
      <vs-row v-if="$helper.isAllowedToModifyGeneratedCRUD('edit', dataType)">
        <vs-col vs-lg="12">
          <vs-card>
            <div slot="header">
              <h3>
                {{
                  $t("crudGenerated.sort.title", {
                    tableName: dataType.displayNameSingular,
                  })
                }}
              </h3>
            </div>
            <vs-row>
              <vs-col vs-lg="12">
                <table class="table table-striped">
                  <draggable v-model="data" tag="tbody" @change="sortData">
                    <tr :key="index" v-for="(field, index) in data">
                      <td style="width: 1%">
                        <vs-icon
                          icon="drag_indicator"
                          class="drag_icon"
                        ></vs-icon>
                      </td>
                      <td
                        :data="
                          field[
                            $caseConvert.stringSnakeToCamel(dataType.orderColumn)
                          ]
                        "
                      >
                        <strong>{{
                          field[
                            $caseConvert.stringSnakeToCamel(
                              dataType.orderDisplayColumn
                            )
                          ]
                        }}</strong>
                      </td>
                    </tr>
                  </draggable>
                </table>
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
                <h3>
                  {{
                    $t("crudGenerated.warning.notAllowedToRead", {
                      tableName: dataType.displayNameSingular,
                    })
                  }}
                </h3>
              </vs-col>
            </vs-row>
          </vs-card>
        </vs-col>
      </vs-row>
    </template>
    <template v-if="isMaintenance">
      <badaso-breadcrumb-row full>
      </badaso-breadcrumb-row>

      <vs-row v-if="$helper.isAllowedToModifyGeneratedCRUD('browse', dataType)">
        <vs-col vs-lg="12">
          <div class="flex flex-direction-column justify-content-center align-items-center" >
            <img src="/badaso-images/maintenance.png" alt="Maintenance Icon">

            <h1 class="mt-4 text-center">We are under <br>maintenance</h1>
          </div>
        </vs-col>
      </vs-row>
    </template>
  </div>
</template>

<script>
import _ from "lodash";
import draggable from "vuedraggable";

export default {
  name: "CrudGeneratedSort",
  components: {
    draggable,
  },
  data: () => ({
    dataType: {},
    record: {},
    data: [],
    isMaintenance: false
  }),
  mounted() {
    this.getAllEntityData();
  },
  methods: {
    getAllEntityData() {
      this.$openLoader();
      this.$api.badasoEntity
        .all({
          slug: this.$route.params.slug,
        })
        .then((response) => {
          this.$closeLoader();
          this.dataType = response.data.dataType;
          this.data = response.data.entities.data;
        })
        .catch((error) => {
          if (error.status === 503) {
            this.isMaintenance = true;
          }
          this.$closeLoader();
          this.$vs.notify({
            title: this.$t("alert.danger"),
            text: error.message,
            color: "danger",
          });
        });
    },
    sortData(e) {
      this.$openLoader();
      this.$api.badasoEntity
        .sort({
          slug: this.$route.params.slug,
          data: this.data,
        })
        .then((response) => {
          this.$closeLoader();
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
  },
};
</script>
<style lang="scss" scoped>
.flex {
  display: flex;
}

.justify-content-center {
  justify-content: center;
}

.flex-direction-column {
  flex-direction: column;
}

.align-items-center {
  align-items: center;
}
</style>
