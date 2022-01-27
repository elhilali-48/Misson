@extends('layouts.main')

@section('content')
    <div class="row">
        <div class="col-12">
            <div id="myModal" class="modal" tabindex="-1">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title">Ajouter un évenement</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="formAdd" method="POST">
                            @csrf
                        <div class="mb-3">
                            <label for="titre" class="form-label">Titre d'évenement: </label>
                            <input type="text" class="form-control" id="titre" placeholder="Evenement ... " required>
                          </div>
                          <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" rows="3" placeholder="Description" required></textarea>
                          </div>
                          <div class="mb-3">
                            <label  for="time_start" class="form-label">Date de début</label>
                            <input name="start" class="form-control" id="debut" type="datetime-local" required/>
                          </div>
                          <div class="mb-3">
                            <label for="time_start" class="form-label">Date de fin</label>
                            <input name="fin" class="form-control" id="fin" type="datetime-local" required />
                          </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                      <button type="submit" class="btn btn-success" id="addEvent">Ajouter</button>
                    </form>
                    </div>
                  </div>
                </div>
              </div>
            <div id="showEven" class="modal" tabindex="-1">

                <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title">Information de l'évenement : </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                        <h5>Titre : </h5>
                        <p class="titre"></p>
                        <h5>Description : </h5>
                        <p class="description"></p>
                        <h5>Date de début : </h5>
                        <p class="debut"></p>
                        <h5>Date de fin : </h5>
                        <p class="fin"></p>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="button" class="btn btn-success" id="edit">Editer</button>
                        <button type="button" class="btn btn-danger" id="delete">Supprimer</button>
                      </div>
                    </div>
                  </div>
            </div>
            <div id="editModal" class="modal" tabindex="-1">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title">Modifier un évenement</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="formAdd" method="POST">
                            @csrf
                        <div class="mb-3">
                            <label for="titre" class="form-label">Titre d'évenement: </label>
                            <input type="text" class="form-control titre" id="updateTitre"  placeholder="Evenement ... " value="">
                          </div>
                          <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control description" id="updateDescription" rows="3" placeholder="Description" required></textarea>
                          </div>
                          <div class="mb-3">
                            <label  for="time_start" class="form-label">Date de début</label>
                            <input name="start" class="form-control debut" id="updateDebut" type="datetime-local" required/>
                          </div>
                          <div class="mb-3">
                            <label for="time_start" class="form-label">Date de fin</label>
                            <input name="fin" class="form-control fin" id="updateFin" type="datetime-local" required />
                          </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                      <button type="submit" class="btn btn-success" id="updatEvent">Modifier</button>
                    </form>
                    </div>
                  </div>
                </div>
              </div>
            <div id="calendar" class="mt-5">
               
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
          // Configuration d'Ajax
            $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
            // Evenement Ajouter un évenement 
            $('#addEvent').click(function (e) {
            e.preventDefault();
            $(this).html('Sending..');
            // Récuperation des valeures des inputs 
            var titre = document.getElementById('titre').value
            var description = document.getElementById('description').value
            var debut = document.getElementById('debut').value
            var fin = document.getElementById('fin').value
            $.ajax({
                    type : "POST",
                    url : '/calendar',
                    data :{
                        title : titre,
                        start : debut,
                        end : fin,
                        description : description,
                    },
                    error : function(e){
                        Swal.fire(
                            'Error ',
                            'Tous les champs sont obligatoires  ',
                            'error'
                        )
                    }
                    ,
                    success : function(){
                        Swal.fire(
                            'Evenement Ajouté!',
                            'Vous avez ajouter un nouveau évenement :  '+titre,
                            'success',
                        )
                        // Actualiser la page
                       
                        location.reload();

                    }
                })
        });
          // initialisation du calendrier 
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
          initialView: 'dayGridMonth',
          googleCalendarApiKey: 'AIzaSyAPrE8MyHFH7-1EhITVUHlYo7nLeD0njl0',
          eventSources:[
            {
                // Récuperer les evenememnts de la base de donnée 
              url : '/calendar',
             
            }, 
            {
              // Récuperer les evenememnts de Google Calendar
              googleCalendarId: 'elhilali.abdelouahab@gmail.com',
              color: 'green',
            }
          ] ,
          locale : 'fr',
          timeZone : 'local',
          editable: true,
          droppable : true,
          height : 800,
          selectable : true,
          // Header du calendrier
          headerToolbar : {
            left : 'prevYear,prev,next,nextYear today addEventButton',
            center: 'title',
            end : "today prev,next",
            right : 'timeGridWeek,timeGridDay,dayGridMonth,listWeek'
          },
          // personnaliser button Ajouter un évenement
          customButtons :{
            addEventButton:{
                text : 'Ajouter un évenement',
                click: function(){
                   $('#myModal').modal('show')
                }
            }
          },
          select : async function(selectinfo){
            // Ajouter un evenement par selectionner sur le calendrier
            const { value: formValues } = await Swal.fire({
                title: 'Ajouter un évenement',                
                html:
                    '<label class="swal2-label">Titre</label>'+
                    '<input type="text" id="swal-input1" class="swal2-input">' +
                    '<label class="swal2-label"> Description</label>'+
                    '<input  id="swal-input2" class="swal2-input">',
                focusConfirm: true,
                showCancelButton : true,
                inputValidator: (formValues) => {
                    if (!formValues) {
                    alert( 'You need to write something!')
                    }
                },
                preConfirm: () => {
                    // Validation des inputs 
                    if (document.getElementById('swal-input1').value && document.getElementById('swal-input2').value) {
                        return [
                            document.getElementById('swal-input1').value,
                            document.getElementById('swal-input2').value
                        ]
                    } else {
                        // Message d'erreur si un input est vide 
                        Swal.showValidationMessage('Tous les champs sont obligatoires')   
                    }
                }
                })

                if (formValues) {
                    var titre =  formValues[0]
                    var description =   formValues[1]
                
                let dateStart = selectinfo.start.getFullYear() + '-' + (selectinfo.start.getMonth() + 1) + '-' + selectinfo.start.getDate() + ' ' + selectinfo.start.getHours() + ':' + selectinfo.start.getMinutes() + ':'+ selectinfo.start.getSeconds()
                let dateend = selectinfo.end.getFullYear() + '-' + (selectinfo.end.getMonth() + 1) + '-' + selectinfo.end.getDate() + ' ' + selectinfo.end.getHours() + ':' + selectinfo.end.getMinutes() + ':'+ selectinfo.end.getSeconds()
               
                $.ajax({
                    type : "POST",
                    url : '/calendar',
                    data :{
                        title : titre,
                        start : dateStart,
                        end : dateend,
                        description : description,
                    },
                    error : function(e){
                        Swal.fire(
                            'Error ',
                            'Error  '+e.message,
                            'error'
                        )
                    }
                    ,
                    success : function(){
                        Swal.fire(
                            'Evenement Ajouté!',
                            'Vous avez ajouter un nouveau évenement :  '+titre,
                            'success',
                        )
                        // Actualiser la page
                        location.reload();
                    }
                })}
          },
          navLinks : true,
          // Récuperer tous les events 

          

          // Debut :  Selectionner un evenement (affciher les informations )

          eventClick : function(info){
            // Récupere les infos d'un évenement 
            $.ajax({
                  type : "GET",
                  url  : '/calendar/'+info.event.id,
                  success : function(data){
                    console.log(data);
                    $('#showEven').modal('show')
                    $('.titre').text(data.title)
                    $('.description').text(data.description)
                    $('.debut').text(data.start)
                    $('.fin').text(data.end)
                  }
            })
            // Supprimer un évenement
            $('#delete').click(function(){
              $.ajax({
                  type : "DELETE",
                  url  : '/calendar/'+info.event.id,
                  success : function(){
                    $('#showEven').modal('hide');
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: 'Evenement supprimé',
                        showConfirmButton: false,
                        timer: 5500
                    })
                  }
              })
              location.reload()
            });

            $('#edit').click(function(){
              $.ajax({
                  type : "GET",
                  url  : '/calendar/'+info.event.id+'/edit',
                  success : function(data){
                    var dat = new Date(data.start)
                    var form = dat.getFullYear()+'-'+dat.getMonth()+'-'+dat.getDay()+'T'+dat.getHours()+':'+dat.getMinutes()
                    $('#editModal').modal('show')
                    $('.titre').val(data.title)
                    $('.description').val(data.description)
                    $('.debut').val(data.start)
                    $('.fin').val(form)
                  }
              })
            });
            // Modifier un evenement
            $("#updatEvent").click(function(e){     
            e.preventDefault();
            $(this).html('Sending..');  
            var titre = document.getElementById('updateTitre').value
            var description = document.getElementById('updateDescription').value
            var debut = document.getElementById('updateDebut').value
            var fin = document.getElementById('updateFin').value          
            $.ajax({
                    type : "PUT",
                    url : '/calendar/'+info.event.id,
                    data :{
                        title : titre,
                        start : debut,
                        end : fin,
                        description : description,
                    },
                    error : function(e){
                        Swal.fire(
                            'Error ',
                            'Vous devez remplir tous les champs',
                            'error'
                        )
                    }
                    ,
                    success : function(){
                        Swal.fire(
                            'Evenement Modifié!',
                            'Vous avez ajouter un nouveau évenement :  '+titre,
                            'success',
                        )
                        // Actualiser la page
                       
                        location.reload();
                    }
                })
            })
          },    

          // Fin :  Selectionner un evenement 


          // Debut :  Modifier un evenement avec drop Event
          eventDrop : function(info){
            let dateStart = info.event.start.getFullYear() + '-' + (info.event.start.getMonth() + 1) + '-' + info.event.start.getDate() + ' ' + info.event.start.getHours() + ':' + info.event.start.getMinutes() + ':'+ info.event.start.getSeconds()
            let dateend = info.event.end.getFullYear() + '-' + (info.event.end.getMonth() + 1) + '-' + info.event.end.getDate() + ' ' + info.event.end.getHours() + ':' + info.event.end.getMinutes() + ':'+ info.event.end.getSeconds()
            $.ajax({
                    type : "PUT",
                    url : '/calendar/'+info.event.id,
                    data :{
                        title : info.event.title,
                         start : dateStart,
                         end : dateend,
                         description : info.event.extendedProps.description
                        
                    },
                    success : function(){
                        Swal.fire(
                            'Evenement Modifier!',
                            "Vous avez modiifé l\'évenement' :  "+info.event.title,
                            'success',
                        )
                        // Actualiser la page
                       
                    }
                })
        },
          // Fin : Modifier un evenement avec Drop event
          
          // Debut : Modifier un evenement avec Resize Event
          eventResize : function(eventResizeInfo ){
            let dateStart = eventResizeInfo.event.start.getFullYear() + '-' + (eventResizeInfo.event.start.getMonth() + 1) + '-' + eventResizeInfo.event.start.getDate() + ' ' + eventResizeInfo.event.start.getHours() + ':' + eventResizeInfo.event.start.getMinutes() + ':'+ eventResizeInfo.event.start.getSeconds()
            let dateend = eventResizeInfo.event.end.getFullYear() + '-' + (eventResizeInfo.event.end.getMonth() + 1) + '-' + eventResizeInfo.event.end.getDate() + ' ' + eventResizeInfo.event.end.getHours() + ':' + eventResizeInfo.event.end.getMinutes() + ':'+ eventResizeInfo.event.end.getSeconds()
            $.ajax({
                    type : "PUT",
                    url : '/calendar/'+eventResizeInfo.event.id,
                    data :{
                        title : eventResizeInfo.event.title,
                         start : dateStart,
                         end : dateend,
                         description : eventResizeInfo.event.extendedProps.description
                        
                    },
                    success : function(){
                        Swal.fire(
                            'Evenement Modifier!',
                            "Vous avez modiifé l\'évenement' :  "+eventResizeInfo.event.title,
                            'success',
                        )
                        // Actualiser la page
                       
                    }
                })
          }
         // Fin  : Modifier un evenement avec Resize Event
        });
        calendar.render();
        
      });
    </script>
@endsection