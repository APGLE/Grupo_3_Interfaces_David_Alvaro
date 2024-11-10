<template>
  
  <div class="divCrud">
    <h2 class="form-title">Crear Nuevo Evento</h2>
    <form @submit.prevent="submitEvent" class="event-form">
      <div class="form-group">
        <label for="title">Título:</label>
        <input class="form-input" type="text" v-model="event.title" required />
      </div>
      <div class="form-group">
        <label for="category">Categoría:</label>
        <select class="form-input" v-model="event.category_id" required>
          <option value="1">Música</option>
          <option value="2">Deporte</option>
          <option value="3">Tecnología</option>
        </select>
      </div>
      <div class="form-group">
        <label for="date">Fecha de Inicio:</label>
        <input class="form-input" type="datetime-local" v-model="event.start_time" required />
      </div>
      <div class="form-group">
        <label for="date">Fecha de Fin:</label>
        <input class="form-input" type="datetime-local" v-model="event.end_time" required />
      </div>
      <div class="form-group">
        <label for="description">Descripción:</label>
        <textarea class="form-input" v-model="event.description" required></textarea>
      </div>
      <div class="form-group">
        <label for="location">Ubicación:</label>
        <input class="form-input" type="text" v-model="event.location" required />
      </div>
      <div class="form-group">
        <label for="organized_id">ID del Organizador:</label>
        <input class="form-input" type="number" v-model="event.organized_id" required />
      </div>
      <div class="form-group">
        <label for="image">Imagen:</label>
        <input class="form-input" type="file" @change="handleImageUpload" required />
      </div>
      <button type="submit" class="submit-button">Crear Evento</button>
    </form>
  </div>
</template>

<script>
export default {
  data() {
    return {
      event: {
        title: '',
        category_id: '',
        start_time: '',
        end_time: '',
        description: '',
        location: '',
        latitude: '',
        longitude: '',
        price: '',
        max_attendees: '',
        organized_id: ''
      },
      image: null
    };
  },
  methods: {
    async submitEvent() {
      if (new Date(this.event.end_time) <= new Date(this.event.start_time)) {
        alert("La fecha de fin debe ser posterior a la fecha de inicio.");
        return;
      }

      try {
        const formData = new FormData();
        formData.append('title', this.event.title);
        formData.append('category_id', this.event.category_id);
        formData.append('description', this.event.description);
        formData.append('start_time', this.event.start_time);
        formData.append('end_time', this.event.end_time);
        formData.append('location', this.event.location);
        formData.append('latitude', this.event.latitude || 0);
        formData.append('longitude', this.event.longitude || 0);
        formData.append('price', this.event.price || 0);
        formData.append('max_attendees', this.event.max_attendees || 0);
        formData.append('organized_id', this.event.organized_id);
        formData.append('image', this.image);

        formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));

        const response = await fetch('/events/create', {
          method: 'POST',
          body: formData
        });

        if (response.ok) {
          alert('Evento creado con éxito');
          this.resetForm();
        } else {
          alert('Error al crear el evento');
        }
      } catch (error) {
        console.error('Error al enviar el evento:', error);
        alert('Error al crear el evento');
      }
    },
    handleImageUpload(event) {
      this.image = event.target.files[0];
    },
    resetForm() {
      this.event = {
        title: '',
        category_id: '',
        start_time: '',
        end_time: '',
        description: '',
        location: '',
        latitude: '',
        longitude: '',
        price: '',
        max_attendees: '',
        organized_id: ''
      };
      this.image = null;
    }
  }
};
</script>

<style scoped>
.divCrud {
  max-width: 500px;
  margin: 5% auto;
  padding: 2%;
  background: #6c5c39;
  border-radius: 10px;
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
  color: #faf3e4;
  text-align: center;
}

.form-title {
  font-size: 1.8em;
  margin-bottom: 20px;
}

.event-form {
  display: flex;
  flex-direction: column;
}

.form-group {
  margin-bottom: 15px;
  text-align: left;
}

label {
  display: block;
  margin-bottom: 5px;
  font-weight: bold;
  color: #eae0c9;
}

.form-input {
  width: 100%;
  padding: 10px;
  border-radius: 5px;
  border: 1px solid #ddd;
  outline: none;
  transition: border-color 0.3s ease;
  background-color: #3c3120;
  color:#faf3e4;
}

.form-input:focus {
  border-color: #8a7d5a;
}

textarea.form-input {
  resize: vertical;
}

.submit-button {
  padding: 10px 15px;
  margin-top: 20px;
  border: none;
  border-radius: 5px;
  background-color: #8a7d5a;
  color: #faf3e4;
  font-size: 1em;
  cursor: pointer;
  transition: background-color 0.3s ease, transform 0.2s ease;
}

.submit-button:hover {
  background-color: #a18d6d;
  transform: scale(1.03);
}

.submit-button:active {
  transform: scale(1.02);
}
</style>
