<div class="modal fade" id="rentModal" tabindex="-1" role="dialog" aria-labelledby="rentModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="rentModal">Louer mon jardin</h4>
      </div>
      <div class="modal-body">
        Gagnez de l'argent en louant votre jardin sur Kerden.fr<br/>
        Voici les étapes à suivre pour mettre votre jardin en location sur notre site:
        <h4><span class="label label-info">Inscription</span></h4>
        Commencez par <a href="{{ url('/register') }}">vous inscrire</a> sur le site. Vous aurez besoin d'une adresse mail valide.
        <h4><span class="label label-info">Identité</span></h4>
        Pour des raisons de sécurité, et en accord avec les conditions d'utilisation de notre partenaire <a target='_blank' href="https://www.mangopay.com/">MangoPay &copy;</a>, il ne vous sera pas possible d'enregistrer votre jardin
        avant d'avoir prouvé votre identité: <br/>
        Une fois inscrit et connecté, rendez-vous dans votre <a href="{{url('/home')}} ">Espace Membre</a>, puis cliquez sur "Mon compte" puis sur "Prouver mon identité".<br>
        Vous pourrez alors envoyer une copie d'un document d'identité (carte d'identité ou passeport).<br>
        Nous ne stockons pas vos documents, nous les transmettons directement à notre partenaire <a target='_blank' href="https://www.mangopay.com/">MangoPay &copy;</a>, qui s'occupe d'en vérifier la validité.<br>
        Le procédé de vérification de votre identité prend en moyenne 24h (jours ouvrés).
        <h4><span class="label label-info">Location</span></h4>
        Une fois votre identité validée, rendez-vous dans votre <a href="{{ url('/home') }}">Espace Membre</a> et cliquez sur "Louer mon jardin".
        <h4><span class="label label-info">Contact</span></h4>
        Vous avez une question? un doute? vous souhaitez de l'aide pour vous inscrire ou pour enregistrer votre jardin?<br>
        <a href="mailto:contact@kerden.com">Contactez-nous!</a>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Fermer</button>
      </div>
    </div>
  </div>
</div>