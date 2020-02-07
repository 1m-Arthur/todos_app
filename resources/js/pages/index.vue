<template>
  <div class="table-responsive">
    <router-link :to="{ name: 'todo.add' }" class="btn btn-primary btn-md">Tambah Data</router-link>
    <b-table
      striped
      hover
      :items="todos.data"
      :fields="fields"
      show-empty
      @row-clicked="detailsPage"
    >
      <template v-slot:cell(jadwal)="row">
        <p :class="{ 'coret' : row.item.status == 1 }">{{row.item.name}}</p>
      </template>
      <template v-slot:cell(deskripsi)="row">
        <p :class="{ 'coret' : row.item.status == 1 }">{{row.item.note}}</p>
      </template>
      <template v-slot:cell(tanggal_berakhir)="row">
        <p :class="{ 'coret' : row.item.status == 1 }">{{row.item.due_date}}</p>
      </template>
      <template v-slot:cell(status)="row">
        <span class="badge badge-success" v-if="row.item.status == 1">Selesai</span>
        <span class="badge badge-secondary" v-else>Aktif</span>
      </template>
      <template v-slot:cell(aksi)="row">
        <div :key="row.index">
          <button
            class="btn btn-md btn-primary"
            @click="changeStatus(row.item.id)"
            v-if="row.item.status == 0"
          >Selesai</button>
          <button class="btn btn-md btn-danger" @click="hapusList(row.item.id)">Hapus</button>
        </div>
      </template>
    </b-table>
    <div class="float-right">
      <b-pagination
        v-model="page"
        :total-rows="todos.total"
        :per-page="todos.per_page"
        aria-controls="my-table"
        v-if="todos.data && todos.data.length > 0"
      ></b-pagination>
    </div>
  </div>
</template>
<style scoped>
.coret {
  text-decoration: line-through;
}
</style>
<script>
import { mapActions, mapState } from "vuex";
export default {
  name: "TodoIndex",
  created() {
    this.getTodos();
  },
  data() {
    return {
      fields: [
        "jadwal",
        "deskripsi",
        "tanggal_berakhir",
        "status",
        "created_at",
        "aksi"
      ]
    };
  },
  watch: {
    page() {
      this.getTodos();
    }
  },
  computed: {
    ...mapState("todo", {
      todos: state => state.todos
    }),
    page: {
      get() {
        return this.$store.state.todo.page;
      },
      set(val) {
        // console.log(val);
        this.$store.state.todo.page = val;
        // this.$store.dispatch("todo/CHANGE_PAGE", val);
      }
    }
  },
  methods: {
    ...mapActions("todo", ["getTodos", "updateStatus", "hapusTodo"]),
    changeStatus(id) {
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
          this.updateStatus(id).then(() => {
            this.getTodos();
          });
        }
      });
    },
    hapusList(id) {
      this.$swal({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!"
      }).then(result => {
        if (result.value) {
          this.hapusTodo(id).then(() => {
            this.getTodos();
          });
        }
      });
    },
    detailsPage(item) {
      this.$router.push({ name: "todo.detail", params: { id: item.id } });
    }
  }
};
</script>