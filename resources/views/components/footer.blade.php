<!-- @author Benoit Tremblay -->
<div class="footer text-white flex flex-col items-center py-5 ">
    <div class="flex items-center justify-between w-full px-64">
        <div class="flex items-center space-x-32">
            <section class="image-logo-footer flex-shrink-0 items-start ml-20"></section>
            <div class="flex flex-col space-y-2">
                <a href="{{ route('dashboard') }}" class="text-xl text-black hover:underline">Accueil</a>
                <a href="https://cegepoutaouais.qc.ca/" target="_blank" class="text-xl text-black hover:underline">Site Officiel</a>
                <a href="https://cegepoutaouais.qc.ca/wp-content/uploads/2023/10/CA572_18_Politique_de_confidentialite.pdf" target="_blank" class="text-xl text-black hover:underline">Politique de confidentialité</a>
            </div>
        </div>

        <div class="flex items-center space-x-32 mr-12">
            <section class="image-logo-fondation flex-shrink-0 items-start"></section>
            <a href="https://www.fondationcegepoutaouais.ca/" target="_blank" class="text-xl text-black hover:underline">Fondation</a>
        </div>
    </div>

    <!-- Centered Copyright Text -->
    <p class="text-sm text-black mt-8 text-center pb-5">
        {{ date('Y') }} - Tous droits réservés &copy; Cégep de l'Outaouais
    </p>
</div>
