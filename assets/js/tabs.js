// Easy Responsive Tabs Plugin
// Author: Samson.Onna <Email : samson3d@gmail.com>
// https://github.com/samsono/Easy-Responsive-Tabs-to-Accordion
//
// the below is heavily modified from the above

(function ($) {
    if (!$.fn.easyResponsiveTabs) {
        $.fn.extend({
            easyResponsiveTabs: function (options) {
                //Set the default values, use comma to separate the settings, example:
                var defaults = {
                    type: "default", //default, vertical, accordion;
                    closed: false,
                    tabidentify: "",
                    activate: function () {
                    },
                };

                //Variables
                options = $.extend(defaults, options);
                var opt = options,
                    jtype = opt.type,
                    vtabs = "vertical",
                    accord = "accordion";

                //Events
                $(this).bind("tabactivate", function (e, currentTab) {
                    if (typeof options.activate === "function") {
                        options.activate.call(currentTab, e);
                    }
                });

                //Main function
                this.each(function () {
                    var $respTabs = $(this);
                    var $respTabsList = $respTabs.find(
                        "ul.resp-tabs-list." + options.tabidentify
                    );
                    var respTabsId = $respTabs.attr("id");
                    $respTabs
                        .find("ul.resp-tabs-list." + options.tabidentify + " li")
                        .addClass("resp-tab-item")
                        .addClass(options.tabidentify);

                    $respTabs.find(".resp-tabs-container." + options.tabidentify);
                    $respTabs
                        .find(
                            ".resp-tabs-container." + options.tabidentify + " > div"
                        )
                        .addClass("resp-tab-content")
                        .addClass(options.tabidentify);
                    jtab_options();

                    //Properties Function
                    function jtab_options() {
                        if (jtype === vtabs) {
                            $respTabs
                                .addClass("resp-vtabs")
                                .addClass(options.tabidentify);
                        }
                        if (jtype === accord) {
                            $respTabs
                                .addClass("resp-easy-accordion")
                                .addClass(options.tabidentify);
                            $respTabs
                                .find(".resp-tabs-list")
                                .css("display", "none");
                        }
                    }

                    //Assigning the h2 markup to accordion title
                    var $tabItemh2;
                    $respTabs
                        .find(".resp-tab-content." + options.tabidentify)
                        .before(
                            "<h2 class='resp-accordion " +
                            options.tabidentify +
                            "' role='tab'></h2>"
                        );

                    $respTabs
                        .find(".resp-tab-content." + options.tabidentify)
                        .prev("h2");

                    var itemCount = 0;
                    $respTabs.find(".resp-accordion").each(function () {
                        $tabItemh2 = $(this);
                        var $tabItem = $respTabs.find(
                            ".resp-tab-item:eq(" + itemCount + ")"
                        );
                        var $accItem = $respTabs.find(
                            ".resp-accordion:eq(" + itemCount + ")"
                        );
                        $accItem.append($tabItem.html());
                        $accItem.data($tabItem.data());
                        $tabItemh2.attr(
                            "aria-controls",
                            options.tabidentify + "_tab_item-" + itemCount
                        );
                        itemCount++;
                    });

                    //Assigning the 'aria-controls' to Tab items
                    var count = 0,
                        $tabContent;
                    $respTabs.find(".resp-tab-item").each(function () {
                        $tabItem = $(this);
                        $tabItem.attr(
                            "aria-controls",
                            options.tabidentify + "_tab_item-" + count
                        );
                        $tabItem.attr("role", "tab");

                        //Assigning the 'aria-labelledby' attr to tab-content
                        var tabcount = 0;
                        $respTabs
                            .find(".resp-tab-content." + options.tabidentify)
                            .each(function () {
                                $tabContent = $(this);
                                $tabContent.attr(
                                    "aria-labelledby",
                                    options.tabidentify + "_tab_item-" + tabcount
                                );
                                tabcount++;
                            });
                        count++;
                    });

                    // Show correct content area
                    var tabNum = 0;

                    //Active correct tab
                    $(
                        $respTabs.find(".resp-tab-item." + options.tabidentify)[
                            tabNum
                            ]
                    ).addClass("resp-tab-active");

                    //keep closed if option = 'closed' or option is 'accordion' and the element is in accordion mode
                    if (
                        options.closed !== true &&
                        !(
                            options.closed === "accordion" &&
                            !$respTabsList.is(":visible")
                        ) &&
                        !(options.closed === "tabs" && $respTabsList.is(":visible"))
                    ) {
                        $(
                            $respTabs.find(
                                ".resp-accordion." + options.tabidentify
                            )[tabNum]
                        ).addClass("resp-tab-active");

                        $(
                            $respTabs.find(
                                ".resp-tab-content." + options.tabidentify
                            )[tabNum]
                        )
                            .addClass("resp-tab-content-active")
                            .addClass(options.tabidentify);
                    }
                    //assign proper classes for when tabs mode is activated before making a selection in accordion mode
                    else {
                        // $($respTabs.find('.resp-tab-content.' + options.tabidentify)[tabNum]).addClass('resp-accordion-closed'); //removed resp-tab-content-active
                    }

                    //Tab Click action function
                    $respTabs.find("[role=tab]").each(function () {
                        var $currentTab = $(this);
                        $currentTab.on("click", function () {
                            var $currentTab = $(this);
                            var $tabAria = $currentTab.attr("aria-controls");

                            if (
                                $currentTab.hasClass("resp-accordion") &&
                                $currentTab.hasClass("resp-tab-active")
                            ) {
                                $respTabs
                                    .find(
                                        ".resp-tab-content-active." +
                                        options.tabidentify
                                    )
                                    .slideUp("", function () {
                                        $(this).addClass("resp-accordion-closed");
                                    });
                                $currentTab.removeClass("resp-tab-active");
                                return false;
                            }
                            if (
                                !$currentTab.hasClass("resp-tab-active") &&
                                $currentTab.hasClass("resp-accordion")
                            ) {
                                $respTabs
                                    .find(".resp-tab-active." + options.tabidentify)
                                    .removeClass("resp-tab-active");
                                $respTabs
                                    .find(
                                        ".resp-tab-content-active." +
                                        options.tabidentify
                                    )
                                    .slideUp()
                                    .removeClass(
                                        "resp-tab-content-active resp-accordion-closed"
                                    );
                                $respTabs
                                    .find("[aria-controls=" + $tabAria + "]")
                                    .addClass("resp-tab-active");

                                $respTabs
                                    .find(
                                        ".resp-tab-content[aria-labelledby = " +
                                        $tabAria +
                                        "]." +
                                        options.tabidentify
                                    )
                                    .slideDown()
                                    .addClass("resp-tab-content-active");
                            } else {
                                $respTabs
                                    .find(".resp-tab-active." + options.tabidentify)
                                    .removeClass("resp-tab-active");

                                $respTabs
                                    .find(
                                        ".resp-tab-content-active." +
                                        options.tabidentify
                                    )
                                    .removeAttr("style")
                                    .removeClass("resp-tab-content-active")
                                    .removeClass("resp-accordion-closed");

                                $respTabs
                                    .find("[aria-controls=" + $tabAria + "]")
                                    .addClass("resp-tab-active");

                                $respTabs
                                    .find(
                                        ".resp-tab-content[aria-labelledby = " +
                                        $tabAria +
                                        "]." +
                                        options.tabidentify
                                    )
                                    .addClass("resp-tab-content-active");
                            }
                            //Trigger tab activation event
                            $currentTab.trigger("tabactivate", $currentTab);
                        });
                    });

                    //Window resize function
                    $(window).on("resize", function () {
                        $respTabs
                            .find(".resp-accordion-closed")
                            .removeAttr("style");
                    });
                });
            },
        });
    }
})(jQuery);
