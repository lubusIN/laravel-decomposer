import Alpine from 'alpinejs'
import { dataTable } from './components/dataTable'
import { reportComponent } from './components/reportComponent'

window.Alpine = Alpine

Alpine.data('reportComponent', reportComponent)
Alpine.data('dataTable', dataTable)

Alpine.start()
