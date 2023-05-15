import DataTable from 'datatables.net-dt';
import 'datatables.net-buttons-bs5';

import 'datatables.net-responsive-dt';
 
// DataTables initialisation
let reads = new DataTable('#my_reads', {
});

let books = new DataTable('#books', {
});

let authors = new DataTable('#authors', {
});

let users = new DataTable('#users', {
});