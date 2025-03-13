<table>
    <thead>
        <tr>
            <td>filiale</td>
            <td>CODE_CLIENT</td>
            <td>NUMERO_DU_COMPTE</td>
            <td>chapitre</td>
            <td>DEVISE_DU_PRET</td>
            <td>REFERENCE_DU_DOSSIER</td>
            <td>NOM_CLIENT</td>
            <td>DATE_DE_REFERENCE</td>
            <td>TYPE_DE_CREDIT</td>
            <td>NOMINAL_EN_DEVISE</td>
            <td>ENCOURS_EN_DEVISE</td>
            <td>IMPAYES_EN_DEVISE</td>
            <td>NOMINAL_EN_GNF</td>
            <td>ENCOURS_EN_GNF</td>
            <td>IMPAYES_EN_GNF</td>
            <td>DATE_PREMIER_IMP</td>
            <td>DATE_DERNIER_IMP</td>
            <td>NB_IMPAYE</td>
            <td>PERIODICITE</td>
            <td>NOMBRE_ECHEANCES</td>
            <td>TAUX_INTERET</td>
            <td>TAUX_EFFECTIF</td>
            <td>GESTIONNAIRE</td>
        </tr>
    </thead>
    <tbody>
        @foreach ($datas as $item)
            <tr>
                <td>{{ $item->filiale }}</td>
                <td>{{ $item->code_client }}</td>
                <td>{{ $item->numero_du_compte }}</td>
                <td>{{ $item->chapitre }}</td>
                <td>{{ $item->devise_du_pret }}</td>
                <td>{{ $item->reference_du_dossier }}</td>
                <td>{{ $item->nom_client }}</td>
                <td>{{ $item->date_de_reference }}</td>
                <td>{{ $item->type_de_credit }}</td>
                <td>{{ $item->nominal_en_devise }}</td>
                <td>{{ $item->encours_en_devise }}</td>
                <td>{{ $item->impayes_en_devise }}</td>
                <td>{{ $item->nominal_en_gnf }}</td>
                <td>{{ $item->encours_en_gnf }}</td>
                <td>{{ $item->impayes_en_gnf }}</td>
                <td>{{ $item->date_premier_imp }}</td>
                <td>{{ $item->date_dernier_imp }}</td>
                <td>{{ $item->nb_impaye }}</td>
                <td>{{ $item->periodicite }}</td>
                <td>{{ $item->nombre_echeances }}</td>
                <td>{{ $item->taux_interet }}</td>
                <td>{{ $item->taux_effectif }}</td>
                <td>{{ $item->gestionnaire }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
