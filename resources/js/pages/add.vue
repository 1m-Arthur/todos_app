<template>
  <div class="card">
    <div class="card-header">
      <h3 class="card-title">Tambah Data</h3>
    </div>
    <div class="card-body">
      <div class="form-group">
        <label for>Agenda</label>
        <input
          type="text"
          class="form-control"
          :class="{ 'is-invalid' : errors.name }"
          v-model="todo.name"
        />
        <p class="text-danger" v-if="errors.name">{{ errors.name[0] }}</p>
      </div>
      <div class="form-group">
        <label for>Deskripsi</label>
        <input type="text" class="form-control" v-model="todo.note" />
      </div>
      <div class="form-group">
        <label for>Tanggal</label>
        <v-date-picker v-model="todo.due_date" :available-dates="{start: new Date(), end: null}">
          <template slot-scope="props">
            <input
              type="text"
              :value="props.inputValue"
              @change="props.updateValue($event.target.value)"
              class="form-control"
            />
          </template>
        </v-date-picker>
      </div>
      <div class="form-group">
        <button class="btn btn-primary btn-md" @click="submit">Tambah</button>
      </div>
    </div>
  </div>
</template>
<script>
import { mapActions, mapState, mapMutations } from "vuex";
export default {
  data() {
    return {
      todo: {
        name: "",
        note: "",
        due_date: new Date()
      }
    };
  },
  computed: {
    ...mapState(["errors"])
  },
  methods: {
    ...mapActions("todo", ["simpanTodo"]),
    ...mapMutations(["CLEAR_ERROR"]),
    submit() {
      this.simpanTodo(this.todo).then(() => {
        this.todo = {
          name: "",
          note: "",
          due_date: new Date()
        };
        this.$router.push({ name: "todo.index" });
      });
    }
  },
  destroyed() {
    this.CLEAR_ERROR();
  }
};
</script>