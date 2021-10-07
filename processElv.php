<?php
require __DIR__ . '/vendor/pdfparser/alt_autoload.php-dist';
require __DIR__ . '/vendor/fpdm/fpdm.php';

if ($_POST) {
    // var_dump($_FILES['files']['tmp_name'][0]);
    // die;

    // Importation de PDF Parser
    $parser = new \Smalot\PdfParser\Parser();

    $fields = [
        'train' => $_POST['train'],
        'date' => (new Datetime($_POST['date']))->format('d-m-Y'),
        'origine' => $_POST['from'],
        'numerosWgs' => '',
        'types' => '',
        'codesDanger' => '',
        'codesOnu' => '',
    ];

    foreach ($_FILES['files']['tmp_name'] as $file) { 
        // Lecture du fichier PDF
        $pdf = $parser->parseFile($file);

        // Vérification si le PDF est bien un eLV
        if (!preg_match('`NumÈro LVE: [\d+]`', $pdf->getText())) {
            echo 'Le(s) fichier(s) fournit ne semble(nt) pas etre un(des) fichier(s) valide(s)';
            die;
        }

        // Recherche des wagons
        $parsedPDF = preg_split(
            '`(\d{4} \d{3} \d{4}[- ]\d).*`',
            $pdf->getText(),
            -1,
            PREG_SPLIT_DELIM_CAPTURE
        );

        // var_dump($parsedPDF);
        // die;

        $wagons = [];
        for ($i = 1; $i < count($parsedPDF); $i = $i + 2) {
            preg_match('` (\d{2,3}),? UN`', $parsedPDF[$i + 1], $codeDanger);
            preg_match('` UN (\d{4})`', $parsedPDF[$i + 1], $codeONU);
            $type = substr($codeDanger[1], 0, 1) === '2' ? 'GD' : 'MD';

            $wagons[] = [
                'numero' => preg_replace('`(.+)[- ](.)`', '$1-$2', $parsedPDF[$i]),
                'type' => $type,
                'codeDanger' => $codeDanger[1],
                'codeOnu' => $codeONU[1],
            ];
        }

        foreach ($wagons as $wagon) {
            $fields['numerosWgs'] .= $wagon['numero'] . PHP_EOL;
            $fields['types'] .= $wagon['type'] . PHP_EOL;
            $fields['codesDanger'] .= $wagon['codeDanger'] . PHP_EOL;
            $fields['codesOnu'] .= $wagon['codeOnu'] . PHP_EOL;

        }
    }

    

    $listeMD = new FPDM('templates/listeMD.pdf');

    $listeMD->Load($fields, true);
    $listeMD->Merge();
    $listeMD->Output();

}