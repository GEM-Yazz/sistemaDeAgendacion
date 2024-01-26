<template>
  <section class="c-section c-section--home">
    <div>
      <div class="c-block c-blockfixed">
        <div class="
          c-block__top
          d-flex
          flex-row
          justify-content-between
          align-items-center
          bg-pri-color"
        >

          <h2 class="c-block__title white">
            Visita Showroom
          </h2>
          <span class="c-block__step" :class="{'opacity-0': step == 6 }">
            Paso {{step}}
          </span>
        </div>
        <div class="c-block__content">
          <transition duration="300" name="fade" mode="out-in">
            <div v-if="step === 1" key="home">
              <div class="c-block__resume">
                <h3>¿Sabías que puedes hacer una visita a nuestro Showroom?*</h3>
                <span>
                  Haz click en el botón de abajo y agenda una
                  visita a nuestro Showroom para <strong>probar nuestros productos</strong>.
                </span>
                <br><br>
                <div class="c-homedisclaimer">
                  *Las visitas sólo aplican para Showroom de Lima, Perú.
                </div>
              </div>
              <div class="c-block__button text-center">
                <button
                  type="button"
                  class="c-button c-button--primary c-button--primary-long  mb-4"
                  @click="nextStep(2)">
                  Agenda tu visita aquí
                </button>
              </div>
            </div>
            <div v-if="step === 2" key="date">
              <div class="row align-items-center">
                <div class="col-12">
                  <div class="c-block__left">
                    <button class="c-return" @click="step = 1">
                      <Icon icon="system-uicons:arrow-left" />
                      <span>
                        Volver
                      </span>
                    </button>
                    <div class="c-meet__name">
                      <span class="c-meet__icon">
                        <!-- <Icon icon="ri:user-fill" /> -->
                        <img src="@/assets/images/user.png" >
                      </span>
                      <span class="w-100">
                        Agenda tu visita
                      </span>
                    </div>
                    <div class="c-meet__subtitle pri-color">
                      Elige una fecha
                    </div>
                  </div>

                </div>
                <div class="col-12">
                  <div class="fs-30 text-center black ">
                      <Icon icon="zondicons:calendar" />
                    </div>
                  <div class="c-meet__calendar">
                    <span class="position-relative">
                      <!-- <button class="c-meet__arrowl" @click="moveMonth(1)">
                        <Icon icon="bi:chevron-left" />
                      </button>
                      <button class="c-meet__arrowr" @click="moveMonth(-1)">
                        <Icon icon="bi:chevron-right" />
                      </button> -->
                      <v-date-picker
                        v-model="date"
                        ref="calendar"
                        color="red"
                        :min-date="new Date().toISOString()"
                        :disabled-dates='disabledDates'
                        @dayclick="ShowDatebyDay()"
                      />
                    </span>
                  </div>
                </div>
              </div>
            </div>
            <div v-if="step === 3" key="hour">
              <div class="row align-items-center">
                <div class="col-12">
                  <div class="c-block__left">
                    <button class="c-return" @click="step = 2">
                      <Icon icon="system-uicons:arrow-left" />
                      <span>
                        Volver
                      </span>
                    </button>
                    <div class="c-meet__subtitle pri-color mt-0 ms-3 me-3 mb-4">
                      Ahora elige una hora
                    </div>
                    <div class="c-meet__name step-3">
                      <span class="c-meet__icon">
                        <Icon icon="bx:calendar" class="d-none" />
                        <span>{{ newDay }}</span>
                      </span>
                      <span class="c-meet__date">
                        {{ newDate }}
                      </span>
                      <div class=" mt-2">
                        <Icon icon="bx:calendar" class="fs-30"/>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-12">
                  <div class="c-hours">
                    <div>
                      <div class="row gy-2 gx-2">
                        <div
                          class="col-12"
                          v-for="(hour, id) of hourList" :key="`hour-${id}`">
                          <label
                            class="c-hour position-relative"
                            :class="{ 'active' : hourListStatus }"
                          >
                            <input type="radio" name="hours" hidden>
                            <div class="full text-center">
                              {{hour}}
                            </div>
                            <div class="mini position-absolute w-100 h-100">
                              <div class="mini-label">
                                {{hour}}
                              </div>
                              <button
                                type="button"
                                class="c-button c-button--primary"
                                @click="selectedHour(hour), nextStep(4)">
                                Confirmar
                              </button>
                            </div>
                          </label>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div v-if="step === 4" key="form">
              <div class="row align-items-center">
                <div class="col-12">
                  <div class="c-block__left">
                    <button class="c-return" @click="step = 3">
                      <Icon icon="system-uicons:arrow-left" />
                      <span>
                        Volver
                      </span>
                    </button>
                    <div class="c-meet__name step-3 step-4 mt-3 mb-3">
                      <span class="c-meet__icon">
                        <Icon icon="bx:calendar" class="d-none" />
                        <span>{{ newDay }} {{ selecterHour }}</span>
                      </span>
                      <span class="c-meet__date">
                        {{ newDate }}
                      </span>
                      <div class=" mt-2">
                        <Icon icon="bx:calendar" class="fs-40"/>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-12">
                  <div class="c-form">
                    <h3 class="c-form__title">Ingrese su datos</h3>
                    <form>
                      <div
                        class="c-form-group"
                        :class="{ 'c-form-group--error': $v.participant.name.$error }"
                      >
                        <input
                          class="c-form-group__input"
                          type="text"
                          placeholder="Nombre*"
                          v-model.trim="$v.participant.name.$model"
                        />
                        <span class="c-form-group__error" v-if="!$v.participant.name.required">
                          Nombre es requerido
                        </span>
                        <span
                          class="c-form-group__error"
                          v-else-if="!$v.participant.name.minLength"
                        >
                          Nombre deberían tener al menos
                          {{$v.participant.name.$params.minLength.min}}
                          caractéres.
                        </span>
                      </div>
                      <div
                        class="c-form-group"
                        :class="{ 'c-form-group--error': $v.participant.email.$error }"
                      >
                        <input
                          class="c-form-group__input"
                          type="email"
                          placeholder="Correo*"
                          v-model.trim="$v.participant.email.$model"
                        />
                        <span class="c-form-group__error" v-if="!$v.participant.email.required">
                          Correo es requerido
                        </span>
                        <span
                          class="c-form-group__error"
                          v-else-if="!$v.participant.email.alpha"
                        >
                          Correo no válido
                        </span>
                      </div>
                      <div
                        class="c-form-group"
                        :class="{ 'c-form-group--error': $v.participant.phone.$error }"
                      >
                        <input
                          class="c-form-group__input"
                          type="tel"
                          placeholder="Celular*"
                          v-model.trim="$v.participant.phone.$model"
                        />
                        <span class="c-form-group__error" v-if="!$v.participant.phone.required">
                          Celular es requerido
                        </span>
                        <span
                          class="c-form-group__error"
                          v-else-if="!$v.participant.phone.minLength"
                        >
                          Celular deberían tener al menos
                          {{$v.participant.phone.$params.minLength.min}}
                          caractéres.
                        </span>
                      </div>
                      <div
                        class="c-form-group"
                        :class="{ 'c-form-group--error': $v.participant.product.$error }"
                      >
                        <select
                          class="c-form-group__select"
                          v-model.trim="$v.participant.product.$model"
                        >
                          <option value="" disabled selected>
                            ¿Qué producto quieres probar de nuestro showroom?
                          </option>
                          <option
                            v-for="(item,i) of productList"
                            :key="`product-${i}`"
                            :value="item"
                          >
                            {{item}}
                          </option>
                        </select>
                        <span class="c-form-group__error" v-if="!$v.participant.product.required">
                          Selecciona una opción
                        </span>
                      </div>
                      <div class="c-form-group" :class="{ 'c-form-group--error': false }">
                        <textarea
                          class="c-form-group__textarea"
                          :placeholder="textareaPlaceholder"
                          v-model="participant.message"
                        >
                        </textarea>
                        <span class="c-form-group__error" v-if="false"></span>
                      </div>

                      <div
                        class="c-form-group"
                        :class="{ 'c-form-group--error': $v.participant.politics.$error }"
                      >
                        <div class="c-check mb-1">
                          <label>
                            <input
                              type="checkbox"
                              v-model.trim="$v.participant.politics.$model"
                              value="si"
                            >
                              Acepto las
                          </label>
                          <span @click="nextStep(6)">Políticas de privacidad</span>
                        </div>
                        <span
                          class="c-form-group__error error-center"
                          v-if="!$v.participant.politics.required"
                        >
                          Debes aceptar las Políticas
                        </span>
                      </div>
                      <div
                        class="c-form-group"
                        :class="{ 'c-form-group--error': false }"
                      >
                        <div class="c-check mb-2">
                          <label>
                            <input
                              type="checkbox"
                              v-model="participant.news"
                              value="si"
                            >
                              Solicito recibir publicidad de LG Electronics Perú
                          </label>
                        </div>
                      </div>
                      <div>
                        <button
                          type="button"
                          class="c-button c-button--primary w-100 mb-3"
                          @click="saveParticipant()"
                          :disabled="loading.participant"
                        >
                          {{ (loading.participant) ? 'Enviando...' : 'Registrar'}}
                        </button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
            <div v-if="step === 5" key="confirmation">
              <h2 class="c-block__confirmed text-center">
                <div class="c-block__confirmed-cont">
                  <span class="c-block__confirmed-icon bg-white">
                    <Icon icon="icon-park-solid:check-one" />
                  </span>
                  <p class="c-block__confirmed-text">
                    <span>Confirmado</span>
                    <br>
                    Tu visita a nuestro Showroom fue agendada exitosamente.
                  </p>
                </div>
              </h2>
              <div class="c-block__details text-center">
                <p>
                  <Icon icon="icon-park-solid:check-one" class="fs-30" />
                  <br>
                  <span>{{ finishHour }}</span> /
                  <span>{{ finishDate }}</span>
                </p>

                <div class="c-block__disclaimer">
                  *Se ha enviado una invitación de calendario a su dirección de correo electrónico
                </div>
              </div>
            </div>
            <div v-if="step === 6" key="terminos">
              <button class="c-return" @click="step = 4">
                <Icon icon="system-uicons:arrow-left" />
                <span>
                  Volver
                </span>
              </button>
              <h2 class="c-terminos__title">Políticas de Privacidad</h2>
              <div class="c-terminos__content">
                <p>
                  Por el presente documento el Participante otorga
                  libremente su consentimiento para que sus datos
                  personales sean tratados y almacenados en el banco de
                  datos de “Atención a Clientes”, debidamente inscrito en
                  el Registro Nacional de Protección de Datos Personales con
                  Código de Registro N° 11919 de titularidad de LG ELECTRONICS
                  PERÚ S.A. (en adelante, “LGE PERÚ o NOSOTROS”), con domicilio
                  en Av. República de Colombia N° 791 Piso 12, San Isidro, Lima,
                  Perú, por un plazo indeterminado o hasta que decida revocar el
                  presente consentimiento.
                </p>
                <p>
                  Las finalidades autorizadas son: (i) organizar, implementar y
                  ejecutar la Promoción; (ii) llevar un registro del
                  participante para fines estadísticos e históricos; (iii)
                  remitir promociones, beneficios, concursos, ofertas y, en general,
                  publicidad sobre los productos y servicios de LGE PERÚ; (iv) obtener
                  información de fuentes de acceso públicas y privadas para fines de
                  perfilamiento y prospección comercial; y, (v) ceder total o parcialmente
                  la utilización de las imágenes y voz en ámbito nacional e internacional a
                  LGE PERÚ, en forma irrestricta, indefinida y por cualquier medio que incluye,
                  más no se restringe a televisión, cable, radio, cine, periódicos,
                  revistas, publicidad exterior y/o Internet, redes sociales (teniendo
                  la opción de compartir o publicitar para que llegue a más personas,),
                  afiches, murales internos, plataformas físicas o digitales.
                </p>
                <p>
                  Asimismo, el Participante declara que: (i) cuenta con la
                  autorización expresa de los titulares de los datos personales
                  que aparecen en los videos utilizados para participar en la
                  Promoción; (ii) renuncia de forma irrevocable y permanente a
                  cualquier beneficio o compensación económica o de cualquier
                  naturaleza, por dicho concepto o cualquier otro; (ii) cede
                  y transfiere en forma total e íntegra, de manera exclusiva,
                  ilimitada, a nivel mundial y por el tiempo establecido en el
                  artículo 52º del Decreto Legislativo Nº822, los derechos de
                  autor de las imágenes y voz a LGE PERÚ, dejándose expresamente
                  establecido que la cesión abarca el derecho exclusivo de realizar,
                  autorizar o prohibir la reproducción del video por cualquier forma
                  o procedimiento, la comunicación al público de las imágenes y voz
                  por cualquier medio, la distribución al público, la traducción,
                  adaptación, arreglo u otra transformación de las imágenes y voz
                  y/o cualquier otra forma de utilización de las obras.
                </p>
                <p>
                  Se le comunica que LGE PERÚ podrá compartir y encargar
                  el tratamiento de sus datos personales a organización o
                  personas directamente relacionadas, empresas prestadoras
                  de servicios en la nube y empresas dedicadas a la publicidad
                  o marketing. En estos casos, LGE PERÚ garantizará que el
                  tratamiento de sus datos se limite a las finalidades antes
                  autorizadas, que se mantenga confidencial y se implementen
                  las medidas de seguridad adecuadas.
                </p>
                <p>
                  El Participante manifiesta que se le ha informado que:
                  (i) el detalle de los terceros Los terceros que pueden
                  acceder son: agentes, contratistas, proveedores de servicios,
                  proveedores de premios y, según sea necesario, a las autoridades
                  reguladoras y cualquier variación de estos será actualizada en
                  siguiente enlace https://www.lg.com/pe/privacy; (ii) la presente
                  autorización es indispensable para cumplir con las finalidades
                  antes mencionadas; y, (iii) podrá ejercer los derechos previstos
                  en la Ley N° 29733 enviando su solicitud a la dirección de correo
                  electrónico pdp-peru@lge.com o a la siguiente dirección: Av.
                  República de Colombia N° 791 Piso 12, San Isidro, Lima – Perú “.
                </p>
                <p>
                  En caso, considere que no ha sido atendido, podrá
                  presentar una reclamación ante la Autoridad Nacional
                  de Protección de Datos Personales, dirigiéndose a
                  la Mesa de Partes del Ministerio de Justicia y
                  Derechos Humanos ubicado en Calle Scipión Llona N°
                  350, Miraflores, Lima, Perú.
                </p>
              </div>
              <button class="c-return" @click="step = 4">
                <Icon icon="system-uicons:arrow-left" />
                <span>
                  Volver
                </span>
              </button>
            </div>
          </transition>
        </div>
        <div class="c-block__footer d-flex justify-content-center">
          <span class="c-block__footer-logo">
            <img src="@/assets/images/logo.png">
          </span>
        </div>
      </div>
      <!-- <button @click="isOpen = !isOpen" class="c-mainbutton">
        <Icon icon="majesticons:chat" />
      </button> -->
    </div>
  </section>
</template>

<script>
import {
  required,
  minLength,
  helpers,
} from 'vuelidate/lib/validators';

export default {
  data() {
    return {
      // isOpen: false,
      step: 1,
      date: '',

      dateModific: null,
      optionsDate: null,
      optionsDay: null,
      newDate: null,
      newDay: null,
      array: [],

      hourList: [],
      hourListStatus: false,
      selecterHour: '',
      error: '',

      finishHour: '',
      finishDate: '',

      participant: {
        name: '',
        email: '',
        phone: '',
        product: '',
        message: '',
        politics: [],
        news: [],
      },

      loading: {
        participant: false,
      },

      disabledDates: {
        weekdays: [1, 7],
      },
      highlight: {
        backgroundColor: 'red',
      },
      toastCount: 1,
      productList: [
        'Barra de Sonido - S75Q',
        'Cocina LG con Instaview, 164 L (horno) - LRGL5847S',
        'Horno Microondas NeoChef con Dorador 25 Litros - MH6596DIR',
        'Lavadora de 17 kg carga superior - WT17DV6',
        'Lavadora de 18 kg carga superior - WT18BSB',
        'Lavadora de 19 kg carga superior - WT19BV6',
        'Lavadora de 19 kg carga superior - WT19BSS6H',
        'Lavadora de 21kg carga superior - WT21VV6',
        'Lavaseca de 14 kg de Lavado y 08 Kg de Secado - WD14BVC2S6C',
        'Lavaseca de 15 Kg. de lavado y 08 Kg de secado - WD15EG2S',
        'Lavaseca de 22 kg de Lavado y 13 Kg de Secado - WD22VV2S6',
        'Lavaseca de 22 kg de Lavado y 13 Kg de Secado - WD22BV2S6R',
        'LG gram ultraligero, pantalla IPS de 16” 16:10 y plataforma Intel® Evo™ - 16Z90P-G',
        'LG Monitor Gamer UltraGear 27” Full HD - 27GN750-B',
        'LG NanoCell 86 NANO77 4K Smart TV - 86NANO77SRA',
        'LG OLED evo 65 C3 4K Smart TV - OLED65C3PSA',
        'LG OLED evo 77 G3 D Smart TV - OLED77G3PSA',
        'LG QNED Mini Led 75 QNED85 4K Smart TV - 75QNED85SRA',
        'LG UHD 55 UR8750 4K Smart TV - 55UR8750PSA',
        'LG UHD 65 UR9050 4K Smart TV - 65UR9050PSJ',
        'Monitor Gaming Ergo Nano IPS 1ms (GtG) UltraGear™ de 27 - 27GN880-B',
        'Refrigeradora Bottom Freezer 446L - GB46TGT',
        'Refrigeradora French Door 426L - LM57SDT',
        'Refrigeradora Side by Side 617L - LS66SDP',
        'Refrigeradora Top Freezer 424L - GT44AGD',
        'Secadora 9 Kg, carga frontal - DF9WVC2S6',
        'Torre de lavado WashTower™ 22Kg lavado / 16Kg de secado – Verde - WK22GGS6',
      ],
    };
  },
  computed: {
    textareaPlaceholder() {
      return 'Por favor, comparte cualquier cosa que nos ayude a estar preparados para tu visita.';
    },
  },
  mounted() {
    // const formattedTime = new Date().toLocaleTimeString('en-US',
    // { hour: 'numeric', minute: '2-digit', hour12: true }).toLowerCase();
    // console.log(formattedTime, 'ghoraaaa');
    const esFechaDeHoy = new Date('2023/10/20').toDateString() === new Date().toDateString();
    console.log(esFechaDeHoy, 'esHoy');
  },
  validations: {
    participant: {
      name: {
        required,
        minLength: minLength(4),
      },
      email: {
        required,
        alpha: helpers.regex('alpha', /.+@.+\..+/),
      },
      phone: {
        required,
        minLength: minLength(9),
      },
      product: {
        required,
      },
      politics: {
        required,
      },
    },
  },
  methods: {
    format() {
      if (this.date) {
        this.dateModific = new Date(this.date);
        this.optionsDay = {
          weekday: 'long',
        };
        this.optionsDate = {
          year: 'numeric', month: 'numeric', day: 'numeric',
        };
        this.newDay = this.dateModific.toLocaleDateString('es-ES', this.optionsDay);
        this.dateOption = this.dateModific.toLocaleDateString('sv', this.optionsDate);
        this.array = this.dateOption.split('-');
        this.newDate = `${this.array[0]}/${this.array[1]}/${this.array[2]}`;
        this.newDay = this.newDay.toLowerCase();
      }
    },
    ShowDatebyDay() {
      this.format();

      const dayName = this.newDay === 'miércoles' ? 'miercoles' : this.newDay;

      fetch(`${process.env.VUE_APP_API}/schedules?day=${dayName}&date=${this.newDate}`, {
        method: 'GET',
      })
        .then((res) => {
          if (res.status >= 200 && res.status < 300) {
            return res.json();
          }

          throw res;
        })
        .then((response) => {
          if (response.status) {
            // lista de horas
            const responseData = response.data;
            // verificar si es hoy
            const esHoy = new Date(this.newDate).toDateString() === new Date().toDateString();

            if (esHoy) {
              // Obtener la hora actual
              const now = new Date();
              const [h, m] = [now.getHours(), now.getMinutes()];
              const amOrPm = h >= 12 ? 'pm' : 'am';
              const currentTime = `${h}:${m < 10 ? '0' : ''}${m} ${amOrPm}`;

              // Filtra las horas
              const futureHours = responseData.filter((time) => new Date(`2000-01-01 ${time}`) > new Date(`2000-01-01 ${currentTime}`));
              console.log(responseData, 'hours');
              console.log(futureHours, 'futureHours');
              console.log(futureHours, 'futureHours');
              console.log(futureHours.length !== 0, 'ya no hay horas');

              if (futureHours.length !== 0) {
                this.hourList = futureHours;
                this.nextStep(3);
              } else {
                this.makeToast();
                this.error = 'No hay horas disponibles para esta fecha';
              }
            } else {
              this.hourList = responseData;
              this.nextStep(3);
            }
          } else {
            this.makeToast();
            this.error = response.message;
          }
        })
        .catch((err) => {
          if (err.status === 401) {
            this.error = err.message;
          } else {
            this.makeToast();
          }

          throw err;
        })
        .finally(() => {
        });
    },
    saveParticipant() {
      this.$v.$touch();
      console.log(this.participant.politics);
      console.log(this.participant.news, 'nnn');

      if (!this.$v.$invalid) {
        const formData = new FormData();

        formData.append('fullname', this.participant.name);
        formData.append('email', this.participant.email);
        formData.append('phone', this.participant.phone);
        formData.append('product', this.participant.product);
        formData.append('message', this.participant.message);
        formData.append('politics', this.participant.politics.length ? 1 : 0);
        formData.append('news', this.participant.news.length ? 1 : 0);
        formData.append('date', this.newDate);
        formData.append('hour', this.selecterHour);

        this.loading.participant = true;

        fetch(`${process.env.VUE_APP_API}/bookings`, {
          method: 'POST',
          body: formData,
        })
          .then((res) => {
            if (res.status >= 200 && res.status < 300) {
              return res.json();
            }

            throw res;
          })
          .then((response) => {
            if (response.status) {
              this.nextStep(5);
              this.closeSuccess();
            } else {
              this.error = response.message;

              this.$bvModal.show('modalError');
            }
          })
          .catch((err) => {
            if (err.status === 401) {
              this.$bvModal.show('modalTryAgain');
            } else {
              this.$bvModal.show('modalError');
            }

            throw err;
          })
          .finally(() => {
            this.loading.participant = false;
          });
      }
    },
    closeSuccess() {
      this.$v.$reset();

      this.participant = {
        name: '',
        email: '',
        phone: '',
        product: '',
        message: '',
        politics: '',
      };
    },
    nextStep(n) {
      if (n === 3 || n === 4) {
        setTimeout(() => {
          this.step = n;
          this.hourListStatus = false;
        }, 400);
      } else {
        this.step = n;
      }
    },
    selectedHour(id) {
      this.selecterHour = id;
      this.finishHour = this.selecterHour;
      this.finishDate = this.newDate;
      this.hourListStatus = true;
    },
    makeToast(append = false) {
      this.toastCount += 1;
      this.$bvToast.toast('No hay horas disponibles para esta fecha', {
        title: 'LG',
        autoHideDelay: 5000,
        appendToast: append,
      });
    },
    moveMonth(n) {
      console.log(n);
    },
  },
};
</script>
