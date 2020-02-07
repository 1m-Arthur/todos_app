<template>
  <div class="row">
    <div class="col-md-12 mb-4">
      <router-link :to="{ name: 'todo.index' }" class="btn-secondary btn btn-md">Kembali</router-link>
    </div>
    <div class="col-md-6">
      <div class="card">
        <div class="card-body">
          <h4>
            {{todo.name}}
            <sup>
              <b-badge>{{ todo.due_date }}</b-badge>
            </sup>
          </h4>
          <blockquote>{{ todo.note }}</blockquote>
          <hr />
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="card">
        <div class="card-body">
          <div class="form-group">
            <input
              type="text"
              placeholder="Add Task.."
              v-model="name"
              class="form-control"
              @keyup.enter="submit"
              :disabled="todo.status == 1"
              :class="{'is-invalid' : errors.name }"
            />
            <p class="text-danger" v-if="errors.name">{{ errors.name[0] }}</p>
            <b-table
              striped
              hover
              :items="todo.details"
              :fields="fields"
              responsive
              show-empty
              @row-clicked="updateStatus"
            >
              <template v-slot:cell(name)="val">
                <p :class="{ 'coret' : val.item.status == 1 }">{{ val.item.name }}</p>
              </template>
              <template v-slot:cell(status)="row">
                <span class="badge badge-success" v-if="row.item.status == 1">Selesai</span>
                <span class="badge badge-secondary" v-else>Aktif</span>
              </template>
            </b-table>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<style scoped>
.coret {
  text-decoration: line-through;
}
</style>
<script>
import { mapState, mapActions } from "vuex";
export default {
  created() {
    this.getTodo(this.$route.params.id);
  },
  data() {
    return {
      fields: ["name", "status"],
      name: ""
    };
  },
  computed: {
    ...mapState("todo", {
      todo: state => state.todo
    }),
    ...mapState(["errors"])
  },
  methods: {
    ...mapActions("todo", ["getTodo"]),
    ...mapActions("detail", ["submitDetail", "changeStatus"]),
    submit() {
      this.submitDetail({
        id: this.$route.params.id,
        name: this.name
      }).then(() => {
        this.getTodo(this.$route.params.id).then(() => {
          this.name = "";
        });
      });
    },
    updateStatus(item) {
      this.$swal({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes!"
      }).then(result => {
        if (result.value) {
          this.changeStatus(item.id).then(() => {
            this.getTodo(this.$route.params.id);
          });
        }
      });
    }
  }
};
</script>