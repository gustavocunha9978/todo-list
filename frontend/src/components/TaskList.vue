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

    <!-- Lista de Tarefas Ativas -->
    <h4 class="text-success mb-3">📋 Tarefas Ativas</h4>
    <ul class="list-group shadow-sm mb-4">
      <li
        v-for="task in activeTasks"
        :key="task.id"
        class="list-group-item d-flex justify-content-between align-items-center py-3"
      >
        <!-- Descrição da tarefa -->
        <span class="fw-bold">{{ task.description }}</span>

        <!-- Botões de ação -->
        <div class="btn-group">
          <button @click="toggleTask(task)" class="btn btn-success btn-sm me-1">
            <i class="fas fa-check"></i>
          </button>
          <button @click="deleteTask(task.id)" class="btn btn-danger btn-sm">
            <i class="fas fa-trash"></i>
          </button>
        </div>
      </li>
    </ul>

    <!-- Lista de Tarefas Concluídas -->
    <h4 class="text-secondary mb-3">✅ Concluído</h4>
    <ul class="list-group shadow-sm">
      <li
        v-for="task in completedTasks"
        :key="task.id"
        class="list-group-item d-flex justify-content-between align-items-center py-3 bg-light"
      >
        <!-- Descrição da tarefa riscada -->
        <span class="text-decoration-line-through text-muted">{{ task.description }}</span>

        <!-- Botões de ação -->
        <div class="btn-group">
          <button @click="toggleTask(task)" class="btn btn-secondary btn-sm me-1">
            <i class="fas fa-undo"></i>
          </button>
          <button @click="deleteTask(task.id)" class="btn btn-danger btn-sm">
            <i class="fas fa-trash"></i>
          </button>
        </div>
      </li>
    </ul>
  </div>
</template>

<script>
import api from '../api';

export default {
  name: 'TaskList',
  data() {
    return {
      tasks: [], // Lista de tarefas
      newTask: '' // Nova tarefa a ser adicionada
    };
  },
  computed: {
    // Filtra as tarefas ativas (não concluídas)
    activeTasks() {
      return this.tasks.filter(task => !task.is_done);
    },
    // Filtra as tarefas concluídas
    completedTasks() {
      return this.tasks.filter(task => task.is_done);
    }
  },
  methods: {
    // Buscar todas as tarefas do backend
    async fetchTasks() {
      try {
        const response = await api.get('tasks');
        this.tasks = response.data;
      } catch (error) {
        console.error('Error fetching tasks:', error);
      }
    },
    // Adicionar uma nova tarefa
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
    // Alternar status da tarefa (concluir ou reativar)
    async toggleTask(task) {
      try {
        await api.put(`tasks/${task.id}`, { is_done: !task.is_done });
        this.fetchTasks();
      } catch (error) {
        console.error('Error toggling task:', error);
      }
    },
    // Deletar uma tarefa
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
/* Estilização das tarefas */
.list-group-item {
  transition: all 0.2s ease-in-out;
  font-size: 1.1rem;
}
.list-group-item:hover {
  transform: scale(1.01);
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

/* Botões de ação */
.btn-group .btn {
  transition: transform 0.2s;
}
.btn-group .btn:hover {
  transform: scale(1.1);
}

/* Seção de tarefas concluídas */
.bg-light {
  background-color: #f8f9fa !important;
}
</style>
