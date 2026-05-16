<?php

namespace App\Traits;

use Symfony\Component\HttpFoundation\StreamedResponse;

trait ExportsCsv
{
    protected function downloadCsv($query, $filename, $headers, $callback)
    {
        $response = new StreamedResponse(function () use ($query, $headers, $callback) {
            $handle = fopen('php://output', 'w');

            // Add BOM for Excel compatibility
            fprintf($handle, chr(0xEF).chr(0xBB).chr(0xBF));

            // Add headers
            fputcsv($handle, $headers);

            // Chunk the query for performance
            $query->chunk(200, function ($records) use ($handle, $callback) {
                foreach ($records as $record) {
                    fputcsv($handle, $callback($record));
                }
            });

            fclose($handle);
        });

        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', 'attachment; filename="'.$filename.'"');

        return $response;
    }
}
