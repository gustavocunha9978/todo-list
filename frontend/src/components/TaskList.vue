<template>
  <div class="container mt-5">
    <!-- Título -->
    <h2 class="text-center mb-4 text-primary fw-bold">📝 Todo List</h2>

    <!-- Campo para adicionar nova tarefa -->
    <div class="input-group mb-4 shadow-sm">
      <input
        v-model="newTask"
        type="text"
        class="form-control rounded-start"
        placeholder="Add a new task..."
        @keyup.enter="addTask"
      />
      <button @click="addTask" class="btn btn-primary px-4">
        <i class="fas fa-plus"></i>
      </button>
    </div>

    <!-- Lista de Tarefas -->
    <ul class="list-group shadow-sm">
      <li
        v-for="task in tasks"
        :key="task.id"
        class="list-group-item d-flex justify-content-between align-items-center py-3"
      >
        <!-- Tarefa e estilo -->
        <span
          :class="{
            'text-decoration-line-through text-muted': task.is_done,
            'fw-bold': !task.is_done
          }"
        >
          {{ task.description }}
        </span>

        <!-- Botões de ação -->
        <div class="btn-group">
          <button
            @click="toggleTask(task)"
            :class="['btn btn-sm', task.is_done ? 'btn-secondary' : 'btn-success']"
          >
            <i class="fas fa-check"></i>
          </button>
          <button @click="deleteTask(task.id)" class="btn btn-sm btn-danger">
            <i class="fas fa-trash"></i>
          </button>
        </div>
      </li>
    </ul>

    <!-- Footer -->
    <p class="text-center mt-4 text-secondary">
      🌟 Keep track of your tasks and stay productive!
    </p>
  </div>
</template>

<script>
import api from '../api';

export default {
  name: 'TaskList',
  data() {
    return {
      tasks: [],
      newTask: ''
    };
  },
  methods: {
    async fetchTasks() {
      try {
        const response = await api.get('tasks');
        this.tasks = response.data;
      } catch (error) {
        console.error('Error fetching tasks:', error);
      }
    },
    async addTask() {
      if (this.newTask.trim() === '') return;

      try {
        await api.post('tasks', { description: this.newTask, is_done: false });
        this.newTask = '';
        this.fetchTasks();
      } catch (error) {
        console.error('Error adding task:', error);
      }
    },
    async toggleTask(task) {
      try {
        await api.put(`tasks/${task.id}`, { is_done: !task.is_done });
        this.fetchTasks();
      } catch (error) {
        console.error('Error toggling task:', error);
      }
    },
    async deleteTask(id) {
      try {
        await api.delete(`tasks/${id}`);
        this.fetchTasks();
      } catch (error) {
        console.error('Error deleting task:', error);
      }
    }
  },
  mounted() {
    this.fetchTasks();
  }
};
</script>

<style scoped>
/* Estilização para lista de tarefas */
.list-group-item {
  font-size: 1.1rem;
  background: #f8f9fa;
  border: none;
  transition: transform 0.2s ease, box-shadow 0.2s ease;
}
.list-group-item:hover {
  transform: scale(1.02);
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

/* Botões */
.btn-group .btn {
  transition: all 0.2s ease;
}
.btn-group .btn:hover {
  transform: scale(1.1);
}

/* Campo de input */
.input-group input {
  border-right: none;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}
.input-group button {
  border-left: none;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

/* Footer */
.text-center {
  font-size: 0.9rem;
  font-style: italic;
}
</style>
