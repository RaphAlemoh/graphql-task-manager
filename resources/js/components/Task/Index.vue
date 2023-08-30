<template>
  <div>
    <div class="container mt-2">
      <div class="row">
        <div class="col-12">
          <!-- Page Heading -->
          <div class="d-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Tasks</h1>
            <div class="row justify-content-end">
              <div class="col-md-12">
                <router-link
                  :to="{ name: 'create_task' }"
                  class="btn btn-primary mb-2"
                  >Create Task</router-link
                >
              </div>
            </div>
          </div>
          <div v-if="loading" class="text-center">Loading...</div>
          <div class="row" v-else-if="result && result.tasks">
            <div class="card mx-auto">
              <div class="card-header bg-none">
                <h4>ApTiw Tasks</h4>
              </div>
              <div class="card-body">
                <div
                  class="d-flex align-items-center justify-content-between mb-4"
                >
                  <div class="row">
                    <div class="col-md-12">
                      <div class="input-group mb-3">
                        <input
                          class="form-control"
                          type="search"
                          placeholder="Search by title or description"
                          aria-describedby="button-addon2"
                        />
                        <button
                          class="btn btn-outline-secondary"
                          type="button"
                          id="button-addon2"
                        >
                          Search
                        </button>
                      </div>
                    </div>
                  </div>

                  <div class="row justify-content-end">
                    <div class="col-md-12">
                      <div class="input-group mb-3">
                        <button
                          class="btn btn-outline-secondary dropdown-toggle"
                          type="button"
                          data-bs-toggle="dropdown"
                          aria-expanded="false"
                        >
                          Filter by status
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                          <li>
                            <span
                              class="dropdown-item"
                              @click="filterTasks('not started')"
                              >Not Started</span
                            >
                          </li>
                          <li>
                            <span
                              class="dropdown-item"
                              @click="filterTasks('in progress')"
                              >In Progress</span
                            >
                          </li>
                          <li>
                            <span
                              class="dropdown-item"
                              @click="filterTasks('completed')"
                              >Completed</span
                            >
                          </li>
                        </ul>
                      </div>
                    </div>
                  </div>
                </div>
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th scope="col">#Id</th>
                      <th scope="col">Title</th>
                      <th scope="col">Deadline</th>
                      <th scope="col">Manage</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="task in result.tasks" :key="task.id">
                      <th scope="row">#{{ task.id }}</th>
                      <td>{{ task.title }}</td>
                      <td>
                        {{
                          task.due_date > Date.now() ? "Task due" : "Not due"
                        }}
                      </td>
                      <td>
                        <router-link
                          :to="{
                            name: 'view_task',
                            params: { id: task.id },
                          }"
                          class="btn btn-success btn-space"
                          >View</router-link
                        >
                        <router-link
                          :to="{
                            name: 'edit_task',
                            params: { id: task.id },
                          }"
                          class="btn btn-success btn-space"
                          >Edit</router-link
                        >
                        <button
                          class="btn btn-danger"
                          @click="deleteTask(task.id)"
                        >
                          Delete
                        </button>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { useQuery, useMutation } from "@vue/apollo-composable";
import { TASKS_QUERY, DELETE_TASK, FILTER_TASKS } from "../../graphql/task";
import { reactive, ref } from "vue";

export default {
  setup() {
    const delete_task_id = ref(null);

    const { result, loading } = useQuery(TASKS_QUERY);

    const { mutate: removeTask } = useMutation(DELETE_TASK, () => ({
      update: (cache, { data: { removeTask } }) => {
        let data = cache.readQuery({ query: TASKS_QUERY });

        const delete_task = data.tasks.find(
          (task) => task.id == delete_task_id.value
        );

        cache.evict({ id: cache.identify(delete_task) });
      },
    }));

    // const { query: filterUserTasks } = useQuery(FILTER_TASKS, () => ({
    //   update: (cache, { data: { filterUserTasks } }) => {
    //     let data = cache.readQuery({ query: TASKS_QUERY });
    //     // result = data
    //   },
    // }));

    const deleteTask = (id) => {
      delete_task_id.value = id;
      removeTask({ id: id });
    };

    const filterTasks = (status) => {
      // filterUserTasks({ status: status });
    };

    return {
      result,
      loading,
      deleteTask,
      filterTasks,
    };
  },
};
// export default {
//   data() {
//     return {
//       tasks: [],
//       showMessage: false,
//       message: "",
//       search: null,
//     };
//   },
//   watch: {
//     search() {
//       this.getTasks();
//     },
//   },
//   created() {
//     this.getTasks();
//   },
//   methods: {
//     getTasks() {
//       axios
//         .get("/api/tasks", {
//           params: {
//             search: this.search,
//           },
//         })
//         .then((res) => {
//           this.tasks = res.data.data;
//         })
//         .catch((error) => {
//           console.log(error);
//         });
//     },
//     deleteTask(id) {
//       axios.delete("api/tasks/" + id).then((res) => {
//         this.showMessage = true;
//         this.message = res.data;
//         this.getTasks();
//       });
//     },
//     filterTasks(filter) {
//       // this.tasks = this.tasks.find(el => el.status === filter)
//       this.tasks = _.find(this.tasks, { status: filter });
//     },
//   },
// };
</script>

<style scoped>
.btn-space {
  margin-right: 5px;
}
</style>