<template>
  <section class="wrap">
    <h2 class="mb-1">{{title}}</h2>

    <a
      :href="reportsLink"
      download
      class="button button-primary mb-1">
      Descargar todo (.xls)
    </a>

    <table class="widefat fixed mb-1" cellspacing="0">
      <thead>
        <tr>
          <th id="columnname" class="manage-column column-columnname" scope="col">ID</th>
          <th id="columnname" class="manage-column column-columnname" scope="col">Fecha</th>
          <th id="columnname" class="manage-column column-columnname" scope="col">Nombres</th>
          <th id="columnname" class="manage-column column-columnname" scope="col">Email</th>
          <th id="columnname" class="manage-column column-columnname" scope="col">Teléfono</th>
          <th id="columnname" class="manage-column column-columnname" scope="col">Reserva</th>
          <th id="columnname" class="manage-column column-columnname" scope="col">Producto</th>
          <th id="columnname" class="manage-column column-columnname" scope="col">Mensaje</th>
          <th id="columnname" class="manage-column column-columnname" scope="col">Políticas</th>
          <th id="columnname" class="manage-column column-columnname" scope="col">LG Publicidad</th>
        </tr>
      </thead>
      <tbody>
        <tr
          v-for="(booking, index) of bookings"
          :key="index"
          valign="top"
          class="participants"
        >
          <td class="manage-column column-columnname" scope="col">
            {{ booking.id }}
          </td>
          <td class="manage-column column-columnname" scope="col">{{ getDateFormated(booking.created_at) }}</td>
          <td class="manage-column column-columnname" scope="col">
            <b> 😃 Nombres completos:</b> {{ booking.fullname }} <br><br>
          </td>
          <td class="manage-column column-columnname" scope="col">
            <b> 💌 Email:</b> {{ booking.email }} <br><br>
          </td>
          <td class="manage-column column-columnname" scope="col">
            <b> 📞 Teléfono:</b> {{ booking.phone }} <br><br>
          </td>
          <td class="manage-column column-columnname" scope="col">
            <b> 📅 Fecha:</b> {{ booking.date }} <br><br>
            <b> ⏱ Hora:</b> {{ booking.hour }} <br><br>
          </td>
          <td class="manage-column column-columnname" scope="col">
            <b> 📦 </b> {{ booking.product }} <br><br>
          </td>
          <td class="manage-column column-columnname" scope="col" v-if="booking.message">
            <b> ✉ </b> {{ booking.message }} <br><br>
          </td>
          <td class="manage-column column-columnname" scope="col" v-if="!booking.message">
            <b> ✉ </b> Sin mensajes <br><br>
          </td>
          <td class="manage-column column-columnname" scope="col">
            {{ booking.politics ? 'Sí' : 'No' }}
          </td>
          <td class="manage-column column-columnname" scope="col">
            {{ booking.news ? 'Sí' : 'No' }}
          </td>
        </tr>
      </tbody>
    </table>
    <div class="flex-container align-center">
      <button class="button button-primary">Load more...</button>
    </div>
  </section>
</template>

<script>
export default {
  data() {
    return {
      context: {...panda},

      bookings: [],
      page: 1,

      isLoading: false,

      title: 'Bookings',
    };
  },
  computed: {
    reportsLink: function() {
      return `${this.context.api}/bookings/download`;
    },
  },
  mounted() {
    this.getBookings();
  },
  methods: {
    getBookings: function() {
      this.isLoading = true;

      const request = `${this.context.api}/bookings?page=${this.page}`;

      fetch(request)
        .then(res => {
          if (res.status >= 200 && res.status < 300) {
            return res.json();
          }else{
            throw res
          }
        })
        .then(response => {
          if (response.status) {
            this.bookings = [
              ...this.bookings,
              ...response.data
            ];

            console.log(this.bookings);

            this.page++;
          } else {
            this.page = -1;
          }

          this.isLoading = false;
        })
        .catch(err => {
          this.page = -1;
          this.isLoading = false;

          throw err;
        })
    },
    getDateFormated: function(dateAt) {
      const dateTime  = new Date(dateAt);
      const day       = dateTime.toLocaleDateString('es', { month: 'long', day: 'numeric' });
      const hours     = dateTime.getHours();
      const minutes   = dateTime.getMinutes();
      const seconds   = dateTime.getSeconds();

      return `${ day }, ${ dateTime.getFullYear() }  a las ${ hours >= 10 ? hours : '0' + hours }:${ minutes >= 10 ? minutes : '0' + minutes }:${ seconds >= 10 ? seconds : '0' + seconds }`;
    },
  },
};
</script>
