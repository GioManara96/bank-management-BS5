/**
* Template Name: NiceAdmin - v2.4.1
* Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
* Author: BootstrapMade.com
* License: https://bootstrapmade.com/license/
*/
(function () {
    "use strict";

    /**
     * Easy selector helper function
     */
    const select = (el, all = false) => {
        el = el.trim()
        if (all) {
            return [...document.querySelectorAll(el)]
        } else {
            return document.querySelector(el)
        }
    }

    /**
     * Easy event listener function
     */
    const on = (type, el, listener, all = false) => {
        if (all) {
            select(el, all).forEach(e => e.addEventListener(type, listener))
        } else {
            select(el, all).addEventListener(type, listener)
        }
    }

    /**
     * Easy on scroll event listener 
     */
    const onscroll = (el, listener) => {
        el.addEventListener('scroll', listener)
    }

    /**
     * Sidebar toggle
     */
    if (select('.toggle-sidebar-btn')) {
        on('click', '.toggle-sidebar-btn', function (e) {
            select('body').classList.toggle('toggle-sidebar')
        })
    }

    /**
     * Search bar toggle
     */
    if (select('.search-bar-toggle')) {
        on('click', '.search-bar-toggle', function (e) {
            select('.search-bar').classList.toggle('search-bar-show')
        })
    }

    /**
     * Navbar links active state on scroll
     */
    let navbarlinks = select('#navbar .scrollto', true)
    const navbarlinksActive = () => {
        let position = window.scrollY + 200
        navbarlinks.forEach(navbarlink => {
            if (!navbarlink.hash) return
            let section = select(navbarlink.hash)
            if (!section) return
            if (position >= section.offsetTop && position <= (section.offsetTop + section.offsetHeight)) {
                navbarlink.classList.add('active')
            } else {
                navbarlink.classList.remove('active')
            }
        })
    }
    window.addEventListener('load', navbarlinksActive)
    onscroll(document, navbarlinksActive)

    /**
     * Toggle .header-scrolled class to #header when page is scrolled
     */
    let selectHeader = select('#header')
    if (selectHeader) {
        const headerScrolled = () => {
            if (window.scrollY > 100) {
                selectHeader.classList.add('header-scrolled')
            } else {
                selectHeader.classList.remove('header-scrolled')
            }
        }
        window.addEventListener('load', headerScrolled)
        onscroll(document, headerScrolled)
    }

    /**
     * Back to top button
     */
    let backtotop = select('.back-to-top')
    if (backtotop) {
        const toggleBacktotop = () => {
            if (window.scrollY > 100) {
                backtotop.classList.add('active')
            } else {
                backtotop.classList.remove('active')
            }
        }
        window.addEventListener('load', toggleBacktotop)
        onscroll(document, toggleBacktotop)
    }

    /**
     * Initiate tooltips
     */
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })

    /**
     * Initiate Bootstrap validation check
     */
    var needsValidation = document.querySelectorAll('.needs-validation')

    Array.prototype.slice.call(needsValidation)
        .forEach(function (form) {
            form.addEventListener('submit', function (event) {
                if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()
                }

                form.classList.add('was-validated')
            }, false)
        })

    /**
     * Initiate Datatables
     */
    const datatables = select('.datatable', true)
    datatables.forEach(datatable => {
        new simpleDatatables.DataTable(datatable);
    })

    /**
     * Autoresize echart charts
     */
    const mainContainer = select('#main');
    if (mainContainer) {
        setTimeout(() => {
            new ResizeObserver(function () {
                select('.echart', true).forEach(getEchart => {
                    echarts.getInstanceByDom(getEchart).resize();
                })
            }).observe(mainContainer);
        }, 200);
    }
})();

$(document).ready(function () {
    /**
     * Submit della form per upload immagine profilo
     */
    $("#uploadProfileImg").on("change", () => {
        $("#uploadImageForm").submit();
    });

    /**
     * mostrare la tab giusta a seconda del link cliccato
     */
    // prendiamo l'hash dall'URL
    let hash = window.location.hash;
    let navTabs = $(".nav-tabs .nav-item .nav-link");

    // se non è vuoto
    if (hash != '') {
        // attiviamo la navigazione giusta
        for (let i = 0; i < navTabs.length; i++) {
            navTabs[i].classList.remove("active");
            if (navTabs[i].getAttribute("data-bs-target") === hash) {
                navTabs[i].classList.add("active")
            }
        }

        hash = hash.split("#")[1];
        // e il giusto pannello
        let tabs = $(".tab-pane");
        for (let i = 0; i < tabs.length; i++) {
            tabs[i].classList.remove("show");
            tabs[i].classList.remove("active");
            if (tabs[i].getAttribute("id") === hash) {
                tabs[i].classList.add("show")
                tabs[i].classList.add("active")
            }
        }
    }
    /**
     * rendiamo chiudibili gli alert
     */
    let alertList = document.querySelectorAll('.alert')
    alertList.forEach(function (alert) {
        new bootstrap.Alert(alert)
    })

    /**
     * attivo i link della siebar anche navigando in pagine diverse
     */
    let url = window.location.href;
    url = url.split("/");
    urlFile = url[url.length - 1];
    let sideNavs = $("#sidebar .nav-item a");
    for (let i = 0; i < sideNavs.length; i++) {
        sideNavs[i].classList.add("collapsed");
        if (sideNavs[i].getAttribute("href") == urlFile) {
            sideNavs[i].classList.remove("collapsed");
        }
    }

    /**
     * Tabella risultati ricerca con Datatable
     */
    if ($("#risultati_ricerca").length != 0) {
        $('#risultati_ricerca').DataTable();
    }

    /**
     * Abilitazione seconda select dalla pagina per la ricarica telefonica
     */
    $("#operatoreTelefonico").on("change", () => {
        $("#importoRicarica").removeAttr("disabled");
    })

    /**
     * validatori per l'IBAN e l'importo
     */
    $("#iban").on("change", () => {
        let iban = $("#iban").val();
        $.ajax({
            type: "post",
            dataType: "json",
            url: "assets/includes/iban.inc.php",
            data: {
                iban: iban
            },
            beforeSend: function () {
                $("#iban_error").remove();
                $("#iban_verifier").empty();
            },
            success: function (data) {
                if (data.length > 1) {
                    $("#iban_verifier").append(data[1]);
                    $("#iban_verifier").removeClass("mt-3");
                    $("#iban_verifier").addClass("mb-1");
                    $("#iban").removeClass("mb-3");
                    $("#iban").addClass("input_error");
                    $("#iban").addClass("mb-0");
                    $("#iban").after("<p class='text-danger' style='font-size: 14px;' id='iban_error'><em>" + data[0] + "</em></p>");
                } else {
                    $("#iban_verifier").removeClass("mb-1");
                    $("#iban_verifier").addClass("mt-3");
                    $("#iban").removeClass("mb-0");
                    $("#iban").addClass("mb-3");
                    $("#iban").removeClass("input_error");

                    $("#iban_verifier").append(data[0]);
                }
            }
        });
    });


    $("#importo").on("change", () => {
        let importo = $("#importo").val();
        $.ajax({
            type: "post",
            dataType: "json",
            url: "assets/includes/importo.inc.php",
            data: {
                importo: importo
            },
            beforeSend: function () {
                $("#importo_error").remove();
                $("#importo_verifier").empty();
            },
            success: function (data) {
                if (data.length > 1) {
                    $("#importo_verifier").append(data[1]);
                    $("#importo_verifier").removeClass("mt-3");
                    $("#importo_verifier").addClass("mb-1");
                    $("#importo").removeClass("mb-3");
                    $("#importo").addClass("input_error");
                    $("#importo").addClass("mb-0");
                    $("#importo").after("<p class='text-danger' style='font-size: 14px;' id='importo_error'><em>" + data[0] + "</em></p>");
                } else {
                    $("#importo_verifier").removeClass("mb-1");
                    $("#importo_verifier").addClass("mt-3");
                    $("#importo").removeClass("mb-0");
                    $("#importo").addClass("mb-3");
                    $("#importo").removeClass("input_error");

                    $("#importo_verifier").append(data[0]);
                }
            }
        });
    });

    /**
     * input data validator
     */
    $("#dataAccredito").on("change", () => {
        let dataString = $("#dataAccredito").val();
        let year = parseInt($("#dataAccredito").val().split("-")[0]);
        let month = parseInt($("#dataAccredito").val().split("-")[1]);
        let day = parseInt($("#dataAccredito").val().split("-")[2]);
        
        let date = new Date();
        let today = date.getDate();
        let thisMonth = date.getMonth() + 1;
        let thisYear = date.getFullYear();

        // controllo in primis che non venga immesso un anno o mese precedente all'odierno
        if(thisYear - year > 0 || thisMonth - month > 0) {
            // poi guardo che se sono nel mese corrente o nel prossimo
            if(thisMonth - month == 0) {
                // se sono nel mese corrente non deve essere inserito un giorno precedente ad oggi
                if(today - day > 0) {
                    $("#data_verifier").html("<i class='bi bi-x-circle-fill text-danger fs-2'></i>");
                    $("#dataAccredito").addClass("input_error");
                } else {
                    $("#data_verifier").html("<i class='bi bi-check-circle-fill text-success fs-2'></i>");
                    $("#dataAccredito").removeClass("input_error");
                }
            } else if(month - thisMonth  == 1) {
                // se sono nel mese successivo va bene qualsiasi giorno
                $("#data_verifier").html("<i class='bi bi-check-circle-fill text-success fs-2'></i>");
                $("#dataAccredito").removeClass("input_error");
            } else {
                $("#data_verifier").html("<i class='bi bi-x-circle-fill text-danger fs-2'></i>");
                $("#dataAccredito").addClass("input_error");
            }
        } else {
            $("#data_verifier").html("<i class='bi bi-check-circle-fill text-success fs-2'></i>");
            $("#dataAccredito").removeClass("input_error");
        }
    })

});

/**
     * grafico report nella dashboard
     */
if (document.querySelector("#reportsChart") != null) {
    document.addEventListener("DOMContentLoaded", () => {
        new ApexCharts(document.querySelector("#reportsChart"), {
            series: [{
                name: 'Saldo',
                data: $("#reportsChart").attr("data-saldo").split(","),
            }, {
                name: 'Movimenti',
                data: $("#reportsChart").attr("data-movimenti").split(",")
            }],
            chart: {
                height: 350,
                type: 'area',
                toolbar: {
                    show: false
                },
            },
            markers: {
                size: 4
            },
            colors: ['#4154f1', '#ff771d'],
            fill: {
                type: "gradient",
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.3,
                    opacityTo: 0.4,
                    stops: [0, 90, 100]
                }
            },
            dataLabels: {
                enabled: true
            },
            stroke: {
                curve: 'straight',
                width: 2
            },
            xaxis: {
                type: 'date',
                categories: $("#reportsChart").attr("data-data").split(",")
            },
            tooltip: {
                x: {
                    format: 'dd/MM/yy'
                },
            }
        }).render();
    })
};
